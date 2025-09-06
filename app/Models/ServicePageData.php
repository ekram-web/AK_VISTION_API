<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePageData extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'service_page_data';

    /**
     * The attributes that are mass assignable.
     * An empty array means all attributes are unguarded.
     *
     * @var array
     */
    protected $guarded = [];
}
