<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'price',
        'developer',
        'publisher',
        'release_date',
        'image_url',
        'screenshots',
        'system_requirements',
        'age_rating',
        'is_active',
        'stock',
        'category_id',
    ];

    protected $casts = [
        'release_date' => 'date',
        'screenshots' => 'array',
        'system_requirements' => 'array',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
    ];

    // Generar slug automáticamente
    public static function boot()
    {
        parent::boot();
        
        static::creating(function ($game) {
            if (empty($game->slug)) {
                $game->slug = Str::slug($game->title);
            }
        });
    }

    // Relaciones
    public function category()
    {
        return $this->belongsTo(GameCategory::class, 'category_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function forumPosts()
    {
        return $this->hasMany(ForumPost::class);
    }

    public function userLibraries()
    {
        return $this->hasMany(UserLibrary::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    // Métodos auxiliares
    public function getAverageRating()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function getTotalReviews()
    {
        return $this->reviews()->count();
    }

    public function isInStock()
    {
        return $this->stock > 0;
    }

    public function getFormattedPrice()
    {
        return 'S/ ' . number_format($this->price, 2);
    }
}