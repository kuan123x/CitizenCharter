<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_name',
        'description',
        'office_id',
        'classification',
        'transaction_id',
        'checklist_of_requirements',
        'where_to_secure',
    ];

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    // Define the relationship with the transaction
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    // Define the relationship with service info
    public function serviceInfos()
    {
        return $this->hasMany(ServicesInfo::class);
    }
}
