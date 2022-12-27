<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sale extends Model
{
    use HasFactory;
    protected $table = 'sales';
    protected $fillable =[
        'product_id','Quantity','price','user_name','billnum'
    ];
}
