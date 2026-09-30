<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MakeAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:make-admin {email? : The email address of the user} {--role=admin : The role to assign (admin or moderator)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Promote a user to Admin or Moderator';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');

        if (!$email) {
            $email = $this->ask('Enter the email address of the user to promote');
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email [{$email}] was not found.");
            return 1;
        }

        $role = $this->option('role');
        if (!in_array($role, ['admin', 'moderator'])) {
            $role = 'admin';
        }

        $user->role = $role;
        $user->save();

        $this->info("Successfully promoted user [{$user->name}] ({$user->email}) to {$role}!");
        return 0;
    }
}
