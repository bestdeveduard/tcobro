<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Creditscore extends Model
{
    protected $table = "credit_score";

    public function borrower()
    {
        return $this->hasOne(Borrower::class, 'id', 'borrower_id');
    }

}
