<?php

return [
    'representations'=>explode(',', env('VIDEO_REPRESENTATIONS', 720)),
    'thumbnails_path'=>storage_path(env('THUMBNAILS_PATH', 'app\public\thumbnails')),
    'video_path'=>storage_path(env('VIDEO_PATH', 'app\public\uploads')),
    'hls_path'=>storage_path(env('HLS_PATH', 'app\public\hls')),
    'per_page'=>env('PER_PAGE', 2),
];
