<?php

return [
    'ffmpeg.binaries'  => '/usr/local/bin/ffmpeg',
    'ffprobe.binaries' => '/usr/local/bin/ffprobe',
    'timeout'          => 3600, // The timeout for the underlying process
    'ffmpeg.threads'   => 12,   // The number of threads that FFmpeg should use
];
