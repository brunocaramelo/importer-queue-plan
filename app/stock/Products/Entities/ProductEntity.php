<?php

namespace Stock\Products\Entities;

use \Illuminate\Database\Eloquent\Model;

class ProductEntity extends Model
{

    protected $table = 'products';
    
    protected $fillable = [
        'name', 'description', 'price','code','excluded'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
