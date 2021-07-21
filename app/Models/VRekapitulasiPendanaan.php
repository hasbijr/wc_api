<?php

namespace App\Models;

use App\CustomHelpers;
use Illuminate\Database\Eloquent\Model;

class VRekapitulasiPendanaan extends Model
{
    protected $table = "rekapitulasi_pendanaan";

    protected $primaryKey = null;

    protected $casts = [
        'created_at' => "datetime:Y-m-d H:i:s",
    ];

    protected $appends = ['created_at_tgl_id'];

    // protected $fillable = [];

    // public $timestamps = false;

    // protected $fillable = [];

    // public $timestamps = false;

    public function getCreatedAtTglIdAttribute()
    {
        return CustomHelpers::dateId($this->created_at);
    }
}
