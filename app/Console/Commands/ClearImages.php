<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ClearImages extends Command
{
    protected $signature = 'images:clear {folder}';

    protected $description = 'Clear all images in the templates folder';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $folder = $this->argument('folder');
        $files = Storage::disk('local')->files("images/{$folder}");

        foreach ($files as $file) {
            Storage::disk('local')->delete($file);
        }
        $this->info('Images cleared');
    }
}
