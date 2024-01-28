<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Celular extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $table = 'celulares';

    protected $fillable = ['name', 'price', 'amount','description'];
}
