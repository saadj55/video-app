<?php

namespace App\Console\Commands;

use App\Jobs\ConvertToHLS;
use App\Models\MetaExtract;
use App\Models\Videos;
use Illuminate\Console\Command;
use Streaming\Stream;
use \FFMpeg\Coordinate\TimeCode;
class FormatVideo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'format:video';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        //ffmpeg setup
        $config = config('ffmpeg');

        $ffmpeg = \Streaming\FFMpeg::create($config);

        //read video file from disk
        $video = $ffmpeg->open(public_path('video.mp4'));

        //get meta data from the ffmpeg streams
        $video_meta = new MetaExtract($video->getStreams()->videos());
        $audio_meta = new MetaExtract($video->getStreams()->audios());

        //create an image at a random point in the video for thumbnail
        //this should be queued for faster response times.
        $frame = $video->frame(TimeCode::fromSeconds(rand(1,$video_meta->getDuration())));
        $thumbnail_path = storage_path('app/public/thumbnails') .DIRECTORY_SEPARATOR. time() . '.jpg';
        $frame->save($thumbnail_path);


        //create a new video in db
        $video_rec =  Videos::create([
            'title'=>'Test' . rand(0,99),
            'filename'=>'video.mp4',
            'thumbnail'=>$thumbnail_path
        ]);

        // attach video meta data
        $video_rec->videoMeta()->create([
            'bitrate' => $video_meta->getBitRate(),
            'codec' => $video_meta->getCodec(),
            'duration' => $video_meta->getDuration(),
            'aspect_ratio' => $video_meta->getAspectRatio(),
            'height' => $video_meta->getHeight(),
            'width' => $video_meta->getWidth()
        ]);

        //attach  audio meta data
        $video_rec->audioMeta()->create([
            'bitrate' => $audio_meta->getBitRate(),
            'codec' => $audio_meta->getCodec(),
            'duration' => $audio_meta->getDuration()
        ]);

        //dispatch task to queue for conversion to hls with the video path and db record ref
        ConvertToHLS::dispatch(public_path('video.mp4'), $video_rec);

    }
}
