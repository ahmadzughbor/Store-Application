<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bill extends Model
{
    use HasFactory;
    protected $table = 'bills';
    protected $fillable =[
        'product_name','Quantity','billnum','Quantity_price','user_name'
    ];
}
