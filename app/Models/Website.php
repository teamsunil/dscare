<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    protected $fillable = ['url', 'username', 'password','token_id','title','logo','website_up_down','website_status'];
    public function getPasswordAttribute($value)
    {
        return decrypt($value);
    }

    public function getSharedSecretAttribute($value)
    {
        return decrypt($value);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = encrypt($value);
    }

    public function setSharedSecretAttribute($value)
    {
        $this->attributes['token_id'] = encrypt($value);
    }

}
