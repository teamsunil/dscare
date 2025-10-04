<?php

namespace App\Models;

<<<<<<< HEAD
use Illuminate\Contracts\Encryption\DecryptException;
=======
>>>>>>> ec031a190c7dd3a7601fa865f2938e0b916bb5b3
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
<<<<<<< HEAD
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
=======
    protected $fillable = ['url', 'username', 'password','token_id','title','logo','website_up_down','website_status'];
    public function getPasswordAttribute($value)
    {
        return decrypt($value);
    }

    public function getSharedSecretAttribute($value)
    {
        return decrypt($value);
>>>>>>> ec031a190c7dd3a7601fa865f2938e0b916bb5b3
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = encrypt($value);
    }

    public function setSharedSecretAttribute($value)
    {
        $this->attributes['token_id'] = encrypt($value);
    }
<<<<<<< HEAD
=======

>>>>>>> ec031a190c7dd3a7601fa865f2938e0b916bb5b3
}
