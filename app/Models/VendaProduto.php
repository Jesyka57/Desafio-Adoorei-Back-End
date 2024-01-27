<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendaProduto extends Model
{
    protected $fillable = ['product_id', 'nome', 'price', 'amount'];

    public function venda()
    {
        return $this->belongsTo(Venda::class, 'venda_id');
    }
}
