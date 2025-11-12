<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\CheckUserFavoritesJob;

class SendFavoriteBooksSummaryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'summary:favorite-books';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send favorite books summary email to users with more than 10 favorites';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        dispatch(new CheckUserFavoritesJob());
        return Command::SUCCESS;
        
    }
}
