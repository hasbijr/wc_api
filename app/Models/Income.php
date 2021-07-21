<?php

namespace App\Models;

use App\CustomHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Income extends Model
{
    use SoftDeletes;

    protected $table = "incomes";

    protected $appends = ['sum_nominal', 'tanggal_upload_tgl_id'];

    protected $casts = [
        'created_at' => "datetime:Y-m-d H:i:s",
        'updated_at' => "datetime:Y-m-d H:i:s",
        'deleted_at' => "datetime:Y-m-d H:i:s",
    ];

    // protected $fillable = [];

    // public $timestamps = false;

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function IncomeDetails()
    {
        return $this->hasMany(IncomeDetail::class);
    }


    public function getSumNominalAttribute()
    {
        return $this->IncomeDetails()->sum('nominal');
    }

    public function getTanggalUploadTglIdAttribute()
    {
        return CustomHelpers::dateId($this->created_at);
    }
}
