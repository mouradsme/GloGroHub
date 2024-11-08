<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'supplier_id',
        'price',
        'discounted_price',
        'stock_quantity',
        'ethnic_culture',
        'seasonal_demand',
        'recommended',
        'ai_demand_score',
        'cultural_relevance_score',
        'min_order_quantity',
        'unit',
        'sku',
        'status',
        'image', 

    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity', 'price_at_purchase');
    }
}
