<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPageData extends Model {
    use HasFactory;
    protected $table = 'product_page_data'; // Explicitly link to the table name
    protected $guarded = [];
}
