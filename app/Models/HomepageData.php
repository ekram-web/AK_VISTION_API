<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomepageData extends Model {
    use HasFactory; // <-- THIS WAS MISSING
    protected $guarded = [];
    protected $table = 'homepage_data'; // Explicitly define table name
}
