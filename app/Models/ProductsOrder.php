<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App/Models/ProductsOrder
 *
 * @property int $product_order_id
 * @property int $order_id
 * @property int $product_id
 * @property int $quantity
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon|null $deleted_at
 */
class ProductsOrder extends Pivot
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = 'product_order_id';
    protected $table = 'products_orders';

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
    ];
}
