<?php
namespace App\Models;


use FFMpeg\FFProbe\DataMapping\StreamCollection;

class MetaExtract{

    private $stream;

    public function __construct(StreamCollection $stream)
    {
        $this->stream = $stream;
    }

    public function getAspectRatio(){
        return $this->stream->first()->get('display_aspect_ratio');
    }
    public function getDuration(){
        return $this->stream->first()->get('duration');
    }
    public function getWidth(){
        return $this->stream->first()->get('width');
    }
    public function getHeight(){
        return $this->stream->first()->get('height');
    }
    public function getCodec(){
        return $this->stream->first()->get('codec_name');
    }
    public function getBitRate(){
        return $this->stream->first()->get('bit_rate');
    }
}
