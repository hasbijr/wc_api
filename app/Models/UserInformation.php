<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserInformation extends Model
{
    use SoftDeletes;

    protected $table = "user_informations";

    // protected $fillable = [];

    // public $timestamps = false;

    protected $casts = [
        'created_at' => "datetime:Y-m-d H:i:s",
        'updated_at' => "datetime:Y-m-d H:i:s",
        'deleted_at' => "datetime:Y-m-d H:i:s",
    ];

    public function userinformation()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get model validation rules.
     *
     * @return array
     */
    public static function getValidationRules()
    {
        return [
            'user_information.nama' => 'required',
        ];
    }
}
