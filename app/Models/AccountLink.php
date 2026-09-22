<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountLink extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function linkedAccount()
    {
        return $this->belongsTo(Account::class, 'linked_account_id');
    }
}
