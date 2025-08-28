<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutPageData extends Model {
    use HasFactory; // <-- THIS WAS MISSING
    protected $guarded = [];
    protected $table = 'about_page_data'; // Explicitly define table name
}
