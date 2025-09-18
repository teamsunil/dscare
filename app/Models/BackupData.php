<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BackupData extends Model
{
    protected $table = 'backup_data';

    protected $fillable = [
        'type',
        'file_path',
        'created_at',
        'updated_at',
        'website_id',
    ];  
}
