<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Genre;
use App\Models\Book;
use App\Models\Rental;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\OverdueNotification;


class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $this->handleOverdueRentals();
        })->daily();
    }

    public function handleOverdueRentals()
    {
       $update= Rental::where('due_at', '<', now())
              ->whereNull('returned_at')
              ->update(['overdue' => true]);

        // $overdueRentals = Rental::where('overdue', true)
        //                         ->whereNull('returned_at')
        //                         ->get();

        $overdueRentals=DB::table('rentals as r')
                        ->join('books as b', 'b.id', '=', 'r.book_id')
                        ->join('users as u', 'u.id', '=', 'r.user_id')
                        ->select('u.email', 'b.title', 'r.due_at','u.name')
                        ->whereNull('r.returned_at')
                        ->where('r.due_at', '<', now())
                        ->where('r.overdue', 1)
                        ->get();
       
        foreach ($overdueRentals as $rental) {
           
            Mail::to($rental->email)
                ->send(new OverdueNotification($rental));
        }
    }


    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
