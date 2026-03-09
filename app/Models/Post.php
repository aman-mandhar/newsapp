<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'slug', 'content', 'image_path', 'pdf_url', 'pdf_title',
        'status', 'published_at', 'meta_title', 'meta_description', 'meta_keywords',
        'views_count', 'likes_count'
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function videoLinks()
    {
        return $this->morphMany(VideoLink::class, 'videoable');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            $post->slug = static::generateUniqueSlug($post->title, $post->published_at ?? now());
        });

        static::updating(function ($post) {
            if ($post->isDirty('title')) {
                $post->slug = static::generateUniqueSlug($post->title, $post->published_at ?? now(), $post->id);
            }
        });
    }

    private static function gurmukhiToLatin(string $text): string
    {
        // Gurmukhi digits → ASCII
        $digits = [
            '੧'=>'1','੨'=>'2','੩'=>'3','੪'=>'4','੫'=>'5',
            '੬'=>'6','੭'=>'7','੮'=>'8','੯'=>'9','੦'=>'0',
        ];

        // Consonants / vowels / signs (approximate romanization)
        $map = [
            // independent vowels
            'ਅ'=>'a','ਆ'=>'aa','ਇ'=>'i','ਈ'=>'ii','ਉ'=>'u','ਊ'=>'uu',
            'ਏ'=>'e','ਐ'=>'ai','ਓ'=>'o','ਔ'=>'au',

            // consonants
            'ਕ'=>'k','ਖ'=>'kh','ਗ'=>'g','ਘ'=>'gh','ਙ'=>'ng',
            'ਚ'=>'ch','ਛ'=>'chh','ਜ'=>'j','ਝ'=>'jh','ਞ'=>'ny',
            'ਟ'=>'t','ਠ'=>'th','ਡ'=>'d','ਢ'=>'dh','ਣ'=>'n',
            'ਤ'=>'t','ਥ'=>'th','ਦ'=>'d','ਧ'=>'dh','ਨ'=>'n',
            'ਪ'=>'p','ਫ'=>'ph','ਬ'=>'b','ਭ'=>'bh','ਮ'=>'m',
            'ਯ'=>'y','ਰ'=>'r','ਲ'=>'l','ਵ'=>'v',
            'ਸ਼'=>'sh','ਸ'=>'s','ਹ'=>'h','ੜ'=>'rr','ਲ਼'=>'l',

            // extended (nukta letters commonly seen)
            'ਖ਼'=>'kh','ਗ਼'=>'gh','ਜ਼'=>'z','ਫ਼'=>'f',

            // vowel signs (matras) — very rough but good for slugs
            'ਾ'=>'a','ਿ'=>'i','ੀ'=>'i','ੁ'=>'u','ੂ'=>'u',
            'ੇ'=>'e','ੈ'=>'ai','ੋ'=>'o','ੌ'=>'au',

            // nasalization / other signs (mostly drop or simplify)
            'ਂ'=>'n','ੰ'=>'n','੍'=>'','ੱ'=>'','਼'=>'','ਃ'=>'',
            // danda/purn viram used in Punjabi texts
            '।'=>' ','॥'=>' ',
        ];

        // First map digits
        $text = strtr($text, $digits);
        // Then letters/signs
        $text = strtr($text, $map);

        // Normalize whitespace
        $text = preg_replace('/\s+/u', ' ', $text);

        return trim($text);
    }

    private static function generateUniqueSlug($title, $date = null, $excludeId = null)
    {
        // 1) Transliterate Gurmukhi → Latin
        $ascii = static::gurmukhiToLatin($title);

        // 2) Fallback to Str::ascii (handles other scripts), then final fallback
        if ($ascii === '') $ascii = Str::ascii($title);
        if ($ascii === '') $ascii = 'post';

        // 3) Slugify
        $base = Str::slug($ascii, '-');

        // 4) Append date (published_at preferred; else provided $date; else today)
        $datePart = $date ? \Carbon\Carbon::parse($date)->format('Y-m-d') : now()->format('Y-m-d');
        $base .= '-' . $datePart;

        // 5) Ensure uniqueness
        $slug = $base;
        $i = 1;
        while (
            static::where('slug', $slug)
                ->when($excludeId, fn($q) => $q->where('id','!=',$excludeId))
                ->exists()
        ) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }

    // Scope for filtering
    public function scopeFiltered($query, $search = null, $status = null, $categoryId = null)
    {
        return $query
            ->when($search, function ($q) use ($search) {
                $q->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('content', 'like', "%{$search}%");
                });
            })
            ->when($status, fn ($q) => $q->where('status', $status))
            ->when($categoryId, function ($q) use ($categoryId) {
                $q->whereHas('categories', fn ($catQ) => $catQ->where('id', $categoryId));
            });
    }
    // Scope for broad search
    public function scopeBroadSearch($query, ?string $term)
    {
        if (!filled($term)) return $query;

        // 1) शब्दों में तोड़ो (multiple spaces भी ठीक)
        $parts = preg_split('/\s+/u', trim($term), -1, PREG_SPLIT_NO_EMPTY);

        // 2) LIKE-safe value
        $esc = fn ($s) => str_replace(['\\','%','_'], ['\\\\','\\%','\\_'], $s);

        // 3) ANY word should match (OR across parts)
        return $query->where(function ($outer) use ($parts, $esc) {

            foreach ($parts as $word) {
                $like = '%' . $esc($word) . '%';

                // हर शब्द के लिए एक OR-ग्रुप: (title LIKE OR content LIKE OR cat.name LIKE OR tag.name LIKE)
                $outer->orWhere(function ($q) use ($like) {
                    $q->where('title', 'like', $like)
                    ->orWhere('content', 'like', $like)
                    ->orWhereHas('categories', fn ($c) => $c->where('name', 'like', $like))
                    ->orWhereHas('tags', fn ($t) => $t->where('name', 'like', $like));
                });
            }
        });
    }

    // Author
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Categories
    public function categories()
    {
        return $this->belongsToMany(NewsCategory::class, 'category_post', 'post_id', 'news_category_id');
    }

    // Tags
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag', 'post_id', 'tag_id');
    }

    // Comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Route Key as slug
    public function getRouteKeyName()
    {
        return 'slug';
    }
    // Increment views count
    public function incrementViewsCount()
    {
        $this->increment('views_count');
    }

    // Increment likes count
    public function incrementLikesCount()
    {
        $this->increment('likes_count');
    }
}
