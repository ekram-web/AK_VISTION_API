<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     * This is crucial for telling Laravel to automatically handle the
     * 'data' column as a JSON object, not just a string.
     * @var array
     */
    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
    ];
}
