<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EconomicGroup extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function brands()
    {
        return $this->hasMany(Brand::class, 'economic_group_id');
    }

}