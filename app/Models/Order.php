<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address_id',
        'total_eur',
        'payment_method',
        'payment_status',
        'order_status',
        'inventory_rolled_back',
        'inventory_committed',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'address_id' => 'integer',
        'total_eur' => 'decimal:2',
        'inventory_rolled_back' => 'boolean',
        'inventory_committed' => 'boolean',
    ];

    public const TRANSITIONS = [
        'pending'    => ['processing', 'cancelled'],
        'processing' => ['shipped', 'cancelled'],
        'shipped'    => ['delivered'],
        'delivered'  => [],
        'cancelled'  => [],
    ];

    public function canTransition(string $to): bool
    {
        return in_array($to, self::TRANSITIONS[$this->order_status] ?? [], true);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
