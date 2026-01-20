<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'requested_by',
        // 'worked_by',
        'note',
        'company_id',
        'is_done',
        'created_by',
        'updated_by'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // public function worker()
    // {
    //     return $this->belongsTo(User::class, 'worked_by');
    // }

    // public function workers()
    // {
    //     return $this->hasMany(ProjectWorker::class);
    // }
    
    public function workers()
    {
        return $this->belongsToMany(User::class, 'project_workers', 'project_id', 'user_id')
                    ->withPivot('company_id')
                    ->withTimestamps();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function details()
    {
        return $this->hasMany(DetailProject::class);
    }

}
