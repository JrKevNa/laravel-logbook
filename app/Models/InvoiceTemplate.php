<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceTemplate extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'header',
        'name',
        'sections',
        'position',
        'note',
        'company_id',
        'language',
        'currency',
    ];
}
