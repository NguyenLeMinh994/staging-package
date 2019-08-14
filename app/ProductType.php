<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    protected $table = 'package_product_type';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'status',
        'uid',
        'user_name'
    ];
}
