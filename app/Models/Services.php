<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Services extends Model
{
    use HasFactory;
    use SoftDeletes;
    // use LogsActivity;

    public $table = 'services';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $dates = ['deleted_at'];

    protected $guarded = [];

    public function order_service()
    {
        return $this->belongsTo(\App\Models\Orders::class, 'id', 'service_id');
    }

    public function server()
    {
        return $this->belongsTo(\App\Models\Servers::class, 'server_id', 'id');
    }

    public function service_nat_rules()
    {
        return $this->hasMany(\App\Models\ServiceNatRules::class, 'service_id', 'id');
    }

    public function service_domains()
    {
        return $this->hasMany(\App\Models\ServiceDomains::class, 'service_id', 'id');
    }

}
