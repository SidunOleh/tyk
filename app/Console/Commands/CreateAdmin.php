<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create admin';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->ask('E-mail', 'test@gmail.com');
        $name = $this->ask('Ім\'я', 'Test');
        $phone = $this->ask('Телефон', '111111111');

        $user = User::create([
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'password' => $password = Str::random(8),
            'role' => 'адмін',
        ]);

        $this->info("Login: {$user->email}.");
        $this->info("Password: {$password}.");
    }
}
