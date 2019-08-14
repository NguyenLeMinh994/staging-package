<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'supplier';
    protected $primaryKey = 'supplier_id';
    protected $fillable = [
        'st_id',
        'country_id',
        'country_code',
        'country_name',
        'region_id',
        'region_name',
        'supplier_code',
        'supplier_name',
        'supplier_address_1',
        'supplier_address_2',
        'supplier_phone',
        'supplier_web',
        'supplier_social_1',
        'supplier_social_2',
        'supplier_description',
        'supplier_status',
        'uid',
        'user_name'
    ];
}
?>