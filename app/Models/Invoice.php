<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'document_number',
        'title',
        'header',
        'sections',
        'amount',
        'city',
        'day_date',
        'name',
        'position',
        'note',
        'company_id',
    ];

    protected $casts = [
        'sections' => 'array', // automatically cast JSON to array
    ];

    public function scopeVisibleTo($query, $user)
    {
        if ($user->hasRole('admin')) {
            return $query; // admin sees all
        }

        return $query->where('user_id', $user->id);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
