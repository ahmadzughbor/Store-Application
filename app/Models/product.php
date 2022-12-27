<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable =[
        'name','user_name',
    ];

    public function images()
    {
        return $this->hasMany(productImage::class,'product_id','id');
    }


    public function storage()
    {
        return $this->hasMany(storage::class,'product_id','id');
    }
}
