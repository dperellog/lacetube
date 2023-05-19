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

    /**
     * Method used to convert an uploaded video to MP4 format ready for its download.
     */
    public function handle()
    {
        // Create a video format:
        $bitrateFormat = (new X264)->setKiloBitrate(3000);

        // Open the uploaded video from the right disk:
        FFMpeg::fromDisk('tmp')
            ->open($this->tempPath)

        // Call the 'export' method:
            ->export()

        // Tell the MediaExporter to which disk and in which format we export the video:
            ->toDisk('download')
            ->inFormat($bitrateFormat)

        // Store the video to DB and Filesystem.
            ->save('/'.$this->videoName.'/'.$this->videoName . '.mp4');

    }
}
