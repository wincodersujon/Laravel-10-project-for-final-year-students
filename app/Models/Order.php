<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'fullname',
        'email',
        'phone',
        'tracking_no',
        'pincode',
        'address',
        'status_message',
        'payment_mode',
        'payment_id',
    ];
    /**
     * Get all of the orderItems for the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(Orderitem::class, 'order_id', 'id');
    }
}
