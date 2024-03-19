<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App/Models/ProductReview
 *
 * @property int $product_review_id
 * @property int $product_id
 * @property int $user_id
 * @property string $review
 * @property float $rating
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon|null $deleted_at
 */
class ProductReview extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'product_review_id';

    protected $fillable = [
        'product_id',
        'user_id',
        'review',
        'rating',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function getStarRatingAttribute(): string
    {
        return str_repeat('⭐ ', round($this->rating));
    }
}
