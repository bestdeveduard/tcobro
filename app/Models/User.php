<?php

namespace App\Models;

use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends EloquentUser
{
    protected $table = "users";

    protected $fillable = [
        'email',
        'password',
        'last_name',
        'first_name',
        'permissions',
        'address',
        'notes',
        'phone',
        'gender',
        "country_id",
        "user_name",
        "otp_code",
        "otp_status",
        "active_status",
        "otp_created",
        "operation_type",
        "start_time",
        "end_time",
        "collector_role",
        "business_id",
        "business_name",
        "business_address"
    ];
    
    public function payroll()
    {
        return $this->hasMany(Payroll::class, 'user_id', 'id');
    }
}
