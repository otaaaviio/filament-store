<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App/Models/OrderStatus
 *
 * @property int $order_status_id
 * @property string $name
 *
 * @method static create(array $array)
 */
class OrderStatus extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_status_id';

    protected $table = 'order_status';

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'order_status_id');
    }
}
