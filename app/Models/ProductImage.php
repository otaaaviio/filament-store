<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App/Models/ProductImage
 *
 * @property int $product_image_id
 * @property int $product_id
 * @property string $path
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ProductImage extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_image_id';

    protected $fillable = [
        'path',
        'product_id',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
