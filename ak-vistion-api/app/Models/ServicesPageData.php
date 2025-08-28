<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicesPageData extends Model {
    use HasFactory; // <-- THIS WAS MISSING
    protected $guarded = [];
    protected $table = 'services_page_data'; // Explicitly define table name
}
