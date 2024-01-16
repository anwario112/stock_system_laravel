<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categories;

class Products extends Model
{
    use HasFactory;
    protected $primaryKey = 'ProductID';
    protected $table = 'products';
    protected $fillable = [
        'ProductName',
        'SupplierID',  // Adjusted from 'CompanyID' to match the database column name
        'CategoryID',
        'QuantityPerUnit',
        'UnitPrice',
        'UnitsInStock',
        'UnitsOnOrder',
        'product_cover',
    ];
    public $timestamps = false; // Add this line to disable timestamps
    public function category()
    {
        return $this->belongsTo(Categories::class, 'CategoryID');
    }
}
