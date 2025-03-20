<?php

namespace App\Console\Commands;

use App\Models\WorkShift;
use Illuminate\Console\Command;

class DeleteWorkShifts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'work-shifts:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete work shifts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        WorkShift::getQuery()->delete();
    }
}
