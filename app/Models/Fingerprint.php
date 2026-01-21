<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fingerprint extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_id',
        'enroll_fingerprint',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'enroll_fingerprint' => 'boolean',
    ];
    
    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

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
