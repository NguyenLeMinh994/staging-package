<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackageCategory extends Model
{
    protected $table = 'package_category';
    protected $primaryKey = 'category_id';
    protected $fillable = [
        'category_name',
        'status',
        'uid',
        'user_name'
    ];
}
?>