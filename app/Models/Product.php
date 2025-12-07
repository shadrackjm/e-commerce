<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use SoftDeletes, HasFactory;
    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'slug',
        'sku',
        'short_description',
        'description',
        'price',
        'compare_price',
        'cost_price',
        'stock_quantity',
        'low_stock_threshold',
        'manage_stock',
        'stock_status',
        'is_active',
        'is_featured',
        'has_variants',
        'weight',
        'meta_title',
        'meta_description',
        'views_count',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'compare_price' => 'decimal:2',
            'cost_price' => 'decimal:2',
            'weight' => 'decimal:2',
            'stock_quantity' => 'integer',
            'low_stock_threshold' => 'integer',
            'views_count' => 'integer',
            'manage_stock' => 'boolean',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'has_variants' => 'boolean',
        ];
    }
     /**
     * Scope to only active products
     */
    #[Scope]
    protected function active(Builder $query): void
    {
        $query->where('is_active', true);
    }

    /**
     * Scope to only featured products
     */
    #[Scope]
    protected function featured(Builder $query): void
    {
        $query->where('is_featured', true);
    }

    /**
     * Scope to only in-stock products
     */
    #[Scope]
    protected function inStock(Builder $query): void
    {
        $query->where('stock_status', 'in_stock')
              ->where('stock_quantity', '>', 0);
    }

    /**
     * Scope to products with low stock
     */
    #[Scope]
    protected function lowStock(Builder $query): void
    {
        $query->whereColumn('stock_quantity', '<=', 'low_stock_threshold')
              ->where('stock_quantity', '>', 0);
    }

    /**
     * Scope to filter by category
     */
    #[Scope]
    protected function inCategory(Builder $query, int $categoryId): void
    {
        $query->where('category_id', $categoryId);
    }

    /**
     * Scope to filter by brand
     */
    #[Scope]
    protected function ofBrand(Builder $query, int $brandId): void
    {
        $query->where('brand_id', $brandId);
    }

    /**
     * Scope to filter by price range
     */
    #[Scope]
    protected function inPriceRange(Builder $query, float $min, float $max): void
    {
        $query->whereBetween('price', [$min, $max]);
    }

     // Relationships
     public function category()
     {
         return $this->belongsTo(Category::class);
     }
 
     public function brand()
     {
         return $this->belongsTo(Brand::class);
     }
 
     public function variants()
     {
         return $this->hasMany(ProductVariant::class);
     }
 
     public function images()
     {
         return $this->hasMany(ProductImage::class)->orderBy('sort_order');
     }
 
     public function primaryImage()
     {
         return $this->hasOne(ProductImage::class)->where('is_primary', true);
     }
 
     public function reviews()
     {
         return $this->hasMany(Review::class);
     }
 
     public function approvedReviews()
     {
         return $this->hasMany(Review::class)->where('is_approved', true);
     }

     // Helper Methods
    public function getDiscountPercentageAttribute()
    {
        if ($this->compare_price && $this->compare_price > $this->price) {
            return round((($this->compare_price - $this->price) / $this->compare_price) * 100);
        }
        return 0;
    }

    public function getAverageRatingAttribute()
    {
        return $this->approvedReviews()->avg('rating') ?? 0;
    }

    public function getReviewsCountAttribute()
    {
        return $this->approvedReviews()->count();
    }

    public function incrementViews()
    {
        $this->increment('views_count');
    }

    // Events
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
            if (empty($product->sku)) {
                $product->sku = 'SKU-' . strtoupper(Str::random(8));
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('name') && empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }
 

}
