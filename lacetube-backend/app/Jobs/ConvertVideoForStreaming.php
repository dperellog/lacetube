<?php

namespace App\Jobs;

use App\Models\Video;
use Carbon\Carbon;
use FFMpeg;
use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg as SupportFFMpeg;

class ConvertVideoForStreaming implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $tempPath;
    private $videoName;

    public function __construct($tempPath, $videoName)
    {
        $this->tempPath = $tempPath;
        $this->videoName = $videoName;
    }

    /**
     * Method used to convert an uploaded video to HLS format ready for its streaming.
     */
    public function handle()
    {
        // Create video format:
        $bitrateFormat = (new X264)->setKiloBitrate(3000);

        // Call the 'exportForHLS' method and specify the disk to which we want to export:
        SupportFFMpeg::fromDisk('tmp')
        ->open($this->tempPath)
            ->exportForHLS()
            ->toDisk('streaming')

            ->addFormat($bitrateFormat)

        // Call the 'save' method with a filename:
            ->save('/'.$this->videoName.'/'.$this->videoName . '.m3u8');

        // Generate a thumbnail for the video and store it to filesystem:
        SupportFFMpeg::fromDisk('tmp')
        ->open($this->tempPath)
        ->frame(FFMpeg\Coordinate\TimeCode::fromSeconds(5))
        ->save(storage_path('app/thumbnails/').$this->videoName.'_thumbnail.jpg');
    }
}
