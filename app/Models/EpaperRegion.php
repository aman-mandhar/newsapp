<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EpaperRegion extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_id',
        'article_id',
        'x',
        'y',
        'w',
        'h',
        'label',
        'type',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'x' => 'decimal:6',
            'y' => 'decimal:6',
            'w' => 'decimal:6',
            'h' => 'decimal:6',
            'is_active' => 'boolean',
        ];
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(EpaperPage::class, 'page_id');
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(EpaperArticle::class, 'article_id');
    }
}
