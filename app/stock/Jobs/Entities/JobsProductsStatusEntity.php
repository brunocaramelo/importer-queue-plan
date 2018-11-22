<?php

namespace Stock\Jobs\Entities;

use \Illuminate\Database\Eloquent\Model;

class JobsProductsStatusEntity extends Model
{
    protected $table = 'jobs_products_status';
    protected $fillable = [
        'file_name', 
        'reserved_at', 
        'executed_at',
        'return_message',
        'status_process',
        'status_import'
    ];
    public $timestamps = false;
}
