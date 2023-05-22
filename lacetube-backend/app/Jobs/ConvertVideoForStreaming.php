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
        // create some video formats...
        $bitrateFormat = (new X264('aac', 'libx264'))->setKiloBitrate(2500);
        $bitrateFormat->setAdditionalParameters(['-r', '30']);
        $bitrateFormat->setAdditionalParameters([
            '-preset', 'ultrafast',
            '-movflags', '+faststart'
        ]);


        // call the method export and specify the disk to which we want to export...
        SupportFFMpeg::fromDisk('tmp')
            ->open($this->tempPath)
            ->export()
            ->toDisk('streaming')

            ->inFormat($bitrateFormat)

            // call the 'save' method with a filename...
            ->save('/' . $this->videoName . '/' . $this->videoName . '.mp4');

        //Generar miniatura:
        SupportFFMpeg::fromDisk('tmp')
            ->open($this->tempPath)
            ->frame(FFMpeg\Coordinate\TimeCode::fromSeconds(5))
            ->save(storage_path('app/thumbnails/') . $this->videoName . '_thumbnail.jpg');
    }
}
