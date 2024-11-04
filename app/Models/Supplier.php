<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'contact_name',
        'contact_email',
        'contact_phone',
        'address',
        'city',
        'country',
        'logo',
    ];

    /**
     * Get the products supplied by this supplier.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the user that manages this supplier.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
