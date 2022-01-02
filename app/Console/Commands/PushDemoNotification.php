<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\BrokenRecordNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class PushDemoNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'push:demo';

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
        Notification::send(User::all(), new BrokenRecordNotification(
            'bench press',
            'Tomasz Kisiel',
            '118kg'
        ));

        return 0;
    }
}
