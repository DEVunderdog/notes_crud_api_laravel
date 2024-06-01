<?php

namespace App\Jobs;

use App\Mail\TestMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class EmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $toMail;
    /**
     * Create a new job instance.
     */
    public function __construct($toMail)
    {
        $this->toMail = $toMail;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->toMail)->send(new TestMail());

    }
}
