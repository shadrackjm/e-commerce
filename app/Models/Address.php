<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'full_name',
        'phone',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'postal_code',
        'country',
        'is_default',
        'type',
    ];

    protected function casts(): array
    {
        return [
            'is_default' => 'boolean'
        ];
    }
    #[Scope()]    
    protected function default(Builder $builder){
        $builder->where('is_default', true);
    }

    #[Scope()]    
    protected function ofType(Builder $builder, string $type){
        $builder->where('type', $type);
    }

    //relationship
    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function getFullAddressAttribute(){
        return implode(', ',array_filter([
            $this->address_line_1,
            $this->address_line_2,
            $this->city,
            $this->state,
            $this->postal_code,
            $this->country,
        ]));
    }
}
