<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadVideoRequest;
use App\Jobs\ConvertToHLS;
use App\Models\MetaExtract;
use App\Models\Videos;
use FFMpeg\Coordinate\TimeCode;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class VideosController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(){
        $videos = Videos::orderBy('created_at','desc')->paginate(config('videp.per_page'));
        return view('dashboard', ['videos' => $videos]);
    }
    public function upload(){
        return view('upload');
    }

    public function store(UploadVideoRequest $request)
    {
        $requestData = $request->validated();
        $filename = time().'.'.request()->file->getClientOriginalExtension();
        $request->file->move(config('video.video_path'), $filename);

        //ffmpeg setup
        $config = config('ffmpeg');

        $ffmpeg = \Streaming\FFMpeg::create($config);

        //read video file from disk
        $video = $ffmpeg->open(config('video.video_path') .DIRECTORY_SEPARATOR. $filename);

        //get meta data from the ffmpeg streams
        $video_meta = new MetaExtract($video->getStreams()->videos());
        $audio_meta = new MetaExtract($video->getStreams()->audios());

        //create an image at a random point in the video for thumbnail
        //this should be queued for faster response times.
        $frame = $video->frame(TimeCode::fromSeconds(rand(1,$video_meta->getDuration())));
        $thumbnail_file =  time() . '.jpg';
        $thumbnail_path = config('video.thumbnails_path') .DIRECTORY_SEPARATOR. $thumbnail_file;
        $frame->save($thumbnail_path);


        //create a new video in db
        $video_rec =  Videos::create([
            'title'=>$requestData['title'],
            'filename'=>$filename,
            'thumbnail'=>$thumbnail_file
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
        ConvertToHLS::dispatch($filename, $video_rec);
        return redirect()->route('dashboard');
    }

}
