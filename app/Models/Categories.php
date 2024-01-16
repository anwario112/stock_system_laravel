<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products;

class Categories extends Model
{
    use HasFactory;

    protected $primaryKey = 'CategoryID';
    protected $table = 'categories';
    protected $fillable = [
        'CategoryName',
        'Description'
    ];

    public $timestamps = false;

    public function products()
    {
        return $this->hasMany(Products::class, 'CategoryID');
    }
}
