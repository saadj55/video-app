<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AudioMeta extends Model
{
    protected $table = 'audio_meta';
    use HasFactory;
    public $fillable = [
        'codec', 'duration', 'bitrate', 'video_id'
    ];
}
