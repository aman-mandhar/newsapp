<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmbedPdf extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'title',
        'pdf_url',
        'description',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the post that owns the PDF.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
