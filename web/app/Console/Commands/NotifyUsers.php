<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\User as User;
use App\Models\Contact as Contact;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Jobs\SendMailJob;
use App\Mail\Notification;

class NotifyUsers extends Command
{
    protected $signature = 'notify:users';
    protected $description = 'Notify user one week before its contact birthday';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $today = date("m-d", strtotime(Carbon::now()));
        print($today);
        $contacts = Contact::get();
        Log::info('Contacts readed');
        if($contacts !== null){
            foreach($contacts as $contact)
            {
                Log::info('Contact birthday readed');
                $birthday = Carbon::parse($contact->birthday)->format('m-d');
                if ($birthday == $today)
                {
                    Log::info('We have to send a message');
                    dispatch(new SendMailJob(
                        $contact->email,
                        new Notification($contact))
                    );

                    Log::info('Message sent');
                }
            }
        }
        Log::info('Cron Job Finished');
    }
}
