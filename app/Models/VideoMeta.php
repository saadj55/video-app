<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoMeta extends Model
{
    protected $table = 'video_meta';
    use HasFactory;
    public $fillable = [
        'codec', 'aspect_ratio', 'height', 'width', 'duration', 'bitrate', 'video_id'
    ];
}
