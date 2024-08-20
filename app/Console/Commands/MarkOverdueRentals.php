<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MarkOverdueRentals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

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
     * @return int
     */
    public function handle()
    {
        $twoWeeksAgo = now()->subWeeks(2);

        Rental::where('returned_at', null)
            ->where('rented_at', '<=', $twoWeeksAgo)
            ->update(['overdue' => true]);

        $this->info('Overdue rentals have been marked.');
    }
}
