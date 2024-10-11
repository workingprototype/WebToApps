<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appname extends Model
{
    protected $table = 'appname';

    protected $fillable = [
        'appName',
        'appVersion',
        'appDescription',
        'appID',
        'productName',
    ];
}