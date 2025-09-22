<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'price', 'stock', 'image', 'image_id'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
