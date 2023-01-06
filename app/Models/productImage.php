<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class productImage extends Model
{
    use HasFactory;
    protected $table = 'productimage';
    protected $fillable= ['path','name','product_id'];

    public function product()
    {
        return $this->belongsTo(product::class,'product_id','id');
    }
}
