<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'package_name',
        'package_description',
        'package_code',
        'package_price',
        'package_limit',
    ];
}
