<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable =[
        'name','Quantity','Purchasing_price','user_name','selling_price',
    ];

    public function images()
    {
        return $this->hasMany(productImage::class,'product_id','id');
    }
}
