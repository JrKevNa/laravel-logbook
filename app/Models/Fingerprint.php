<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fingerprint extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nik',
        'company_id',
        'upload_user_info_to_machine',
        'enroll_fingerprint',
        'download_user_info_to_program',
        'upload_user_info_to_all_machine',
        'give_password',
        'note',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'enroll_fingerprint' => 'boolean',
    ];
    
    // Relations
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
