<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class returns extends Model
{
    use HasFactory;
    protected $table = 'returns';
    protected $fillable =[
        'name','Quantity','price'
    ];
}
