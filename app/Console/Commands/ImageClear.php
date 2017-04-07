<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Image;
use Illuminate\Console\Command;

/**
 * Clear images command
 *
 * @author  Thomas Wiringa <thomas.wiringa@gmail.com>
 */
class ImageClear extends Command
{
    /**
     * @var string
     */
    public $signature = 'image:clear {--all : Clear all images}';

    /**
     * @var string
     */
    public $description = "Clear images that are more than 1 month old";

    /**
     * Run the command
     *
     * @return int
     */
    public function handle()
    {
        if ($this->option('all')) {
            Image::all()->each(function ($image) {
                $image->delete();
            });

            $this->output->success('All images have been removed successfully');

            \Log::info("[Artisan] All images have been removed");
        } else {
            Image::where('created_at', '<', Carbon::now()->subMonth())->delete();

            $this->output->success('All images older than 1 month have been removed successfully');

            \Log::info("[Artisan] One month old images have been removed");
        }

        return 0;
    }
}