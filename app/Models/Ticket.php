<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'location',
        'image_path',
        'status',
    ];

    /**
     * Get the user that owns the ticket.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category that owns the ticket.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the comments for the ticket.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the status badge color.
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'danger',
            'in_progress' => 'warning',
            'resolved' => 'success',
            default => 'secondary',
        };
    }

    /**
     * Get the status badge text (Indonesian).
     */
    public function getStatusTextAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Menunggu',
            'in_progress' => 'Sedang Diproses',
            'resolved' => 'Selesai',
            default => 'Tidak Diketahui',
        };
    }
}
