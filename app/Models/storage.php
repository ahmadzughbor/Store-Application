<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class storage extends Model
{
    use HasFactory;
    protected $table = 'storage';
    protected $fillable = ['product_id','Quantity','Purchasing_price','selling_price','billnum','user_name' ];


    public function product()
    {
        return $this->belongsTo(product::class,'product_id','id');
    }
}
