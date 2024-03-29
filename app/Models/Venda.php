<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    protected $connection = 'mysql';

    protected $fillable = ['sales_id', 'amount'];

    public function produtos()
    {
        return $this->hasMany(VendaProduto::class, 'venda_id');
    }

    protected $table = 'vendas';
}
