<?php

namespace App\Models;

use App\Enums\OrderStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App/Models/Order
 *
 * @property int $order_id
 * @property int $user_id
 * @property int $order_status_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon|null $deleted_at
 */
class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'order_id';

    protected $fillable = [
        'user_id',
        'order_status_id' => OrderStatusEnum::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id', 'order_status_id');
    }

    public function products(): BelongsToMany
    {
        return $this
            ->belongsToMany(Product::class, 'products_orders', 'order_id', 'order_id')
            ->using(ProductsOrder::class)
            ->withPivot('quantity');
    }

    public function getTotalPriceAttribute()
    {
        return $this->products()->withPivot('quantity')->get()->sum(function ($product) {
            return $product->price * $product->pivot->quantity;
        });
    }
}
