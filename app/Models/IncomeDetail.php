<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IncomeDetail extends Model
{
    use SoftDeletes;

    protected $table = "income_details";

    // protected $fillable = [];

    // public $timestamps = false;

    protected $casts = [
        'created_at' => "datetime:Y-m-d H:i:s",
        'updated_at' => "datetime:Y-m-d H:i:s",
        'deleted_at' => "datetime:Y-m-d H:i:s",
    ];

    public function income()
    {
        return $this->belongsTo(Income::class);
    }
}
