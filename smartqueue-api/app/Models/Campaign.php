<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'subject', 'content', 'status', 'total_recipients', 'processed_recipients'];

    // Uma campanha tem muitos destinatários
    public function recipients()
    {
        return $this->hasMany(Recipient::class);
    }
}