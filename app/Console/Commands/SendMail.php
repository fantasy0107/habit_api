<?php

namespace App\Console\Commands;

use App\Mail\Welcome;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:send {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '送歡迎信';

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
        $email = $this->argument('email');

        Mail::to($email)->send(new Welcome());
    }
}
