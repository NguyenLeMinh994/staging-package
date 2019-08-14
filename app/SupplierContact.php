<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupplierContact extends Model
{
    protected $table = 'supplier_contact';
    protected $primaryKey = 'id';
    protected $fillable = [
        'supplier_id',
        'contact_firstname',
        'contact_lastname',
        'contact_role',
        'contact_skype',
        'contact_email',
        'contact_phone',
        'contact_status',
        'created_at',
        'uid',
        'user_name'
    ];
}
