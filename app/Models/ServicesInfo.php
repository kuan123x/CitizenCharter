<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicesInfo extends Model
{
    use HasFactory;
    protected $table = 'services_infos';

    // Allow mass assignment on these columns
    protected $fillable = [
        'service_id',
        'step',
        'info_title',
        'clients',
        'agency_action',
        'fees',
        'processing_time',
        'total_fees',
        'total_response_time',
        'person_responsible',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
