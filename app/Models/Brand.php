<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'description',
        'logo',
        'website',
        'is_active',
        'sort_order',
    ];
    #[Scope()]
    protected function active(Builder $builder){
        $builder->where('is_active', true);
    }

    #[Scope()]
    protected function sorted(Builder $builder){
        $builder->orderBy('sort_order','asc');
    }

    //relationship
    public function products(){
        return $this->hasMany(Product::class);
    }

    protected static function boot(){
        parent::boot();

        static::creating(function($brand){
            if (empty($brand->slug)) {
                $brand->slug = Str::slug($brand->name);
            }
        });

        static::updating(function($brand){
            if ($brand->isDirty('name') && empty($brand->empty)) {
                $brand->slug = Str::slug($brand->name);
            }
        });
    }
}
