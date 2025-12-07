<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'is_active',
        'sort_order',
        'meta_title',
        'meta_description',
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

        static::creating(function($category){
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function($category){
            if ($category->isDirty('name') && empty($category->empty)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }
}
