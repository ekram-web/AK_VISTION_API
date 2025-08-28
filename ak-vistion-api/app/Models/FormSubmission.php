<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     * This tells Laravel to automatically handle the 'data' column as JSON.
     * @var array
     */
    protected $casts = [
        'data' => 'array',
    ];
}
