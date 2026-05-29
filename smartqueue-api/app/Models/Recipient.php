<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipient extends Model
{
    use HasFactory;

    protected $fillable = ['campaign_id', 'name', 'destination', 'status', 'error_message'];

    // O destinatário pertence a uma campanha
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}