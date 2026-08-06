<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Branch extends Model
{
    protected $fillable = [
        'name',
        'code',
        'phone',
        'email',
        'address',
        'status',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}