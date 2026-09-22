<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $guarded = [];

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    public function account_link()
    {
        return $this->hasMany(AccountLink::class, 'account_id');
    }
}
