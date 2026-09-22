<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categories extends Model
{
    use HasFactory;

    public $guarded = [];

    public function vault()
    {
        return $this->belongsTo(Vault::class, 'vault_id');
    }

    public function accounts()
    {
        return $this->hasMany(Account::class, 'category_id');
    }
}
