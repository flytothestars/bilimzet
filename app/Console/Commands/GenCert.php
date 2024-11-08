<?php

namespace App\Console\Commands;

use App\Data\CertificateData;
use App\Interactors\CertificateImageMaker;
use Illuminate\Console\Command;

class GenCert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'v:gen';

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
     * @return mixed
     */
    public function handle()
    {
        $data = new CertificateData("Оспанкулова Динара Еркеновна",
            "Дефектологтың кәсіби құзіреттілігі. «Педагог - Дефектолог» біліктілігі беріледі",
            "504 (академиялық сағат)", "05", "сентябрь", "2020");
        $uploads = storage_path('uploads');
        $name = 'res.png';
        $path = $uploads . DIRECTORY_SEPARATOR . $name;
        $imageMaker = new CertificateImageMaker();
        $imageMaker->makeImage($data, $path);
        $imageMaker->close();
        echo "Check: $path";
    }
}
