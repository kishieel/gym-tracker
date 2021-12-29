<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class UserPopulateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'populate:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Allows to create user from CLI.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $email = $this->ask('Email address');

        if (User::where('email', $email)->exists()) {
            $this->error('User with given email already exists!');

            return 1;
        }

        $user = new User();
        $user->email = $email;
        $user->first_name = $this->ask('First name');
        $user->last_name = $this->ask('Last name');
        $user->nick_name = $this->ask('Nick name', $user->first_name . ' ' . $user->last_name);
        $user->password = Hash::make($this->secret('Password'));
        $user->verified_at = now();
        $user->save();

        $this->info('User created successfully!');

        return 0;
    }
}
