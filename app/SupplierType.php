<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupplierType extends Model
{
    protected $table = 'supplier_types';
    protected $primaryKey = 'st_id';
    protected $fillable = [
        'st_name',
        'st_status',
        'uid',
        'user_name'
    ];
}
?>