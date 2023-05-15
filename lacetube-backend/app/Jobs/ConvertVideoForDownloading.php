<?php

namespace App\Jobs;

use App\Models\Video;
use Carbon\Carbon;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class ConvertVideoForDownloading implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $tempPath;
    private $videoName;

    public function __construct($tempPath, $videoName)
    {
        $this->tempPath = $tempPath;
        $this->videoName = $videoName;
    }

    public function handle()
    {
        // create a video format...
        $bitrateFormat = (new X264)->setKiloBitrate(3000);

        // open the uploaded video from the right disk...

        FFMpeg::fromDisk('tmp')
            ->open($this->tempPath)

        // call the 'export' method...
            ->export()

        // tell the MediaExporter to which disk and in which format we want to export...
            ->toDisk('download')
            ->inFormat($bitrateFormat)

        // call the 'save' method with a filename...
            ->save('/'.$this->videoName.'/'.$this->videoName . '.mp4');

    }
}
