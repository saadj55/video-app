<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Videos extends Model
{
    use HasFactory;
    public $fillable = [
        'title', 'filename', 'thumbnail'
    ];
    public function audioMeta(){
        return $this->hasOne(AudioMeta::class, 'video_id');
    }
    public function videoMeta(){
        return $this->hasOne(VideoMeta::class,'video_id');
    }

}
