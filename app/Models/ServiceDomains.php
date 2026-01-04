<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceDomains extends Model
{
    use HasFactory;
    // use SoftDeletes;
    // use LogsActivity;

    public $table = 'services_domain';
    protected $primaryKey = 'id';
    public $incrementing = false;
    // protected $dates = ['deleted_at'];

    protected $guarded = [];

    public function service()
    {
        return $this->belongsTo(\App\Models\Services::class, 'service_id', 'id');
    }

}
