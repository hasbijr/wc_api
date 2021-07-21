<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contributor extends Model
{
    use SoftDeletes;

    protected $table = "contributors";

    // protected $fillable = [];

    // public $timestamps = false;

    protected $casts = [
        'created_at' => "datetime:Y-m-d H:i:s",
        'updated_at' => "datetime:Y-m-d H:i:s",
        'deleted_at' => "datetime:Y-m-d H:i:s",
    ];

    /**
     * Get model validation rules.
     *
     * @return array
     */
    public static function getValidationRules()
    {
        return [
            'nama_donatur' => 'required',
            'nik' => 'required',
            'handphone' => 'required',
            'agreement' => 'required',
        ];
    }
}
