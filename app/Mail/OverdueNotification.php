<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
//use App\Models\Rental;


class OverdueNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $rental;

    public function __construct($rental)
    {
        $this->rental = $rental;
    }

    public function build()
    {
      // dd($this->rental);
        return $this->view('notification')
                    ->with(['rental' => $this->rental]);
    }
    
}
