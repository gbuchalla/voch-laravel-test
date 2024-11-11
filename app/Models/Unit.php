<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = ['fantasy_name', 'corporate_name', 'cnpj', 'brand_id'];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class, 'unit_id');
    }
}
