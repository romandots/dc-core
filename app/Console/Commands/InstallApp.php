<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use App\Repository\PersonRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class InstallApp extends Command
{
    public const ADMIN_USERNAME = 'admin';

    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'install:app';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Install app: seed permissions and create admin user';

    /**
     * Create a new command instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * @param PersonRepository $repository
     * @throws \Exception
     */
    public function handle(PersonRepository $repository): void
    {
        $this->info('Seeding all data');
        Artisan::call('db:seed');

        $password = $this->secret('Admin password');
        $confirmPassword = $this->secret('Confirm admin password');
        while ($password !== $confirmPassword) {
            $password = $this->secret('Admin password');
            $confirmPassword = $this->secret('Confirm admin password');
        }

        $existingUser = User::query()->where('username', self::ADMIN_USERNAME)->first();
        if (null !== $existingUser) {
            $existingUser->password = \Hash::make($password);
            $existingUser->save();
            $this->info('Admin user already exists. Password updated.');
            return;
        }

        $firstName = $this->ask('Admin first name');
        $lastName = $this->ask('Admin last name');

        $person = $repository->create([
            'last_name' => $lastName ?? 'User',
            'first_name' => $firstName ?? 'Admin',
        ]);

        /** @var User $user */
        $user = User::query()
            ->create([
                'id' => \uuid(),
                'person_id' => $person->id,
                'name' => "{$lastName} {$firstName}",
                'username' => self::ADMIN_USERNAME,
                'password' => \Hash::make($password ?? '12345678')
            ]);
        $user->assignRole(\App\Services\Permissions\UserRoles::ADMIN);

        $this->info("User {$lastName} {$firstName} created!");
    }
}
