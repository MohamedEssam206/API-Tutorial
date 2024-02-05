<?php

namespace App\Models;

use App\Traits\GeneralTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;
    use  GeneralTrait;

    protected $fillable = [ 'name_ar' , 'name_en' , 'active' ];
}
