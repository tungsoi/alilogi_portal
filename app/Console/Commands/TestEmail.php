<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:email';

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
        $to_name = "dao thanh tung";
        $to_email = "thanhtung.atptit@gmail.com";
        $data = array(
            "name"  =>  "Noreply Alilogi System",
            "body"  =>  "A test mail"
        );

        Mail::send("admin.mail.forgot-password", $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
            ->subject("Laravel Test Mail");
        });
    }
}
