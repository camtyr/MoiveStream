<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use FFMpeg\Format\Video\X264;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\Exporters\HLSVideoFilters;


//convert to hls
class ProcessMovie extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'movie:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $lowBitrate = (new X264)->setKiloBitrate(250);
        $midBitrate = (new X264)->setKiloBitrate(500);
        $highBitrate = (new X264)->setKiloBitrate(1000);

        FFMpeg::fromDisk('uploads')
            ->open('movie-four/raw/movie.mp4')
            ->exportForHLS()
            ->withRotatingEncryptionKey(function ($filename, $contents) {
                Storage::disk('uploads')->put("movie-four/secrets/{$filename}", $contents);
            })
            ->setSegmentLength(300)
            ->addFormat($lowBitrate, function (HLSVideoFilters $filters) {
                $filters->resize(480, 360);
            })
            ->addFormat($midBitrate, function (HLSVideoFilters $filters) {
                $filters->resize(1280, 720);
            })
            ->addFormat($highBitrate, function (HLSVideoFilters $filters) {
                $filters->resize(1920, 1080);
            })
            ->onProgress(function ($progress) {
                $this->info("Progress: {$progress}%");
            })
            ->toDisk('uploads')
            ->save('movie-four/movies/index.m3u8');
    }
}
