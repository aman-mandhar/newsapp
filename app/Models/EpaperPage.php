<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EpaperPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'edition_id',
        'page_no',
        'image_path',
        'thumb_path',
        'width',
        'height',
    ];

    protected function casts(): array
    {
        return [
            'page_no' => 'integer',
            'width' => 'integer',
            'height' => 'integer',
        ];
    }

    public function edition(): BelongsTo
    {
        return $this->belongsTo(EpaperEdition::class, 'edition_id');
    }

    public function regions(): HasMany
    {
        return $this->hasMany(EpaperRegion::class, 'page_id');
    }
}
