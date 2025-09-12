<?php

namespace App\Models;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    protected $fillable = ['url', 'username', 'password', 'token_id', 'title', 'logo', 'website_up_down', 'website_status', 'data'
        , 'pagespeed_screenshot', 'pagespeed_performance', 'pagespeed_seo', 'pagespeed_accessibility', 'pagespeed_best_practices'];
    // public function getPasswordAttribute($value)
    // {
    //     try {
    //         return decrypt($this->attributes['password']);
    //     } catch (DecryptException $e) {
    //         return null;
    //     }
    //     // return decrypt($value);
    // }

    public function getSharedSecretAttribute($value)
    {
        return !empty($value)
            ? decrypt($value)
            : null;
        // return decrypt($value);
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
