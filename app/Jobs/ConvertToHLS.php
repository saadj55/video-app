<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Streaming\FFMpeg;
class ConvertToHLS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $video_path;
    public $path;
    public $video_rec;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($video_path, $video_rec)
    {
        $this->video_path = config('video.video_path') .DIRECTORY_SEPARATOR. $video_path;
        $this->video_rec = $video_rec;
        $this->path = config('video.hls_path') .DIRECTORY_SEPARATOR. time() . '.m3u8';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $ffmpeg = FFMpeg::create(config('ffmpeg'));
        $video = $ffmpeg->open($this->video_path);
        $video->hls()
            ->x264()
            ->autoGenerateRepresentations(config('video.representations'))
            ->save($this->path);

        $this->video_rec->convert_status = 1;
        $this->video_rec->save();
    }
}
