<?php

namespace App\Models;

use Carbon\Carbon;
use function Livewire\Volt\protect;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'type',
        'value',
        'minimum_order_value',
        'maximum_discount',
        'usage_limit',
        'usage_limit_per_customer',
        'starts_at',
        'expires_at',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'decimal:2',
            'minimum_order_value' => 'decimal:2',
            'maximum_discount' => 'decimal:2',
            'usage_limit' => 'integer',
            'usage_limit_per_customer' => 'integer',
            'starts_at' => 'datetime',
            'expires_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    #[Scope]
    protected function active(Builder $query): void
    {
        $query->where('is_active', true);
    }

    //check for valid coupon
    #[Scope]
    protected function valid(Builder $builder){
        $now = Carbon::now();
        $builder->where('is_active', true)
        ->where(function($q) use($now){
            $q->whereNull('starts_at')->orWhere('starts_at', '<=', $now);
        })
        ->where(function($q) use ($now){
            $q->whereNull('expires_at')->orWhere('expires_at','>=', $now);
        });
    }

    //relationships
    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function usages(){
        return $this->hasMany(CouponUsage::class);
    }

    //helper method
    public function isValid(){
        if (!$this->is_active) {
            return false;
        }

        if ($this->expires_at && $this->starts_at->isFuture()) {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        if ($this->usage_limit && $this->usage->count() >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    public function canBeUsedByCustomer($customerId){
        if (!$this->isValid()) {
            return false;
        }

        if($this->usage_limit_per_customer){
            $usageCount = $this->usages()->where('customer_id', $customerId)->count();
            if ($usageCount >= $this->usage_limit_per_customer) {
                return false;
            }
        }

        return true;
    }

    public function calculateDiscount($subtotal){
        if ($this->minimum_order_value && $subtotal < $this->minimum_order_value) {
            return 0;
        }

        if ($this->type === 'percentage') {
            $discount = ($subtotal * $this->value) / 100;
        }else {
            $discount = $this->value;
        }

        if ($this->maximum_discount && $discount > $this->maximum_discount) {
            $discount = $this->maximum_discount;
        }

        return min($discount, $subtotal);
    }
}
