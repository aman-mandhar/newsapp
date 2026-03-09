<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EpaperEdition extends Model
{
    use HasFactory;

    protected $fillable = [
        'edition_name',
        'issue_date',
        'status',
        'pdf_path',
        'total_pages',
        'generated_at',
    ];

    protected function casts(): array
    {
        return [
            'issue_date' => 'date',
            'generated_at' => 'datetime',
            'total_pages' => 'integer',
        ];
    }

    public function pages(): HasMany
    {
        return $this->hasMany(EpaperPage::class, 'edition_id');
    }

    public function articles(): HasMany
    {
        return $this->hasMany(EpaperArticle::class, 'edition_id');
    }

    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function isPublished(): bool
    {
        return $this->status === 'published';
    }
}
