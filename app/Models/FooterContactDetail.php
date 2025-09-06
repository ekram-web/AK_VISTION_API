<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterContactDetail extends Model
{
    use HasFactory;

    // Explicitly define the table name to avoid any pluralization issues
    protected $table = 'footer_contact_details';

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];
}
