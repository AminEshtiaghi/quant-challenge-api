<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    private const STATIC_EMAIL = 'eshtiaghi.amin@gmail.com';
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->createMainUser();
    }

    private function createMainUser()
    {
        if ($this->checkIsMainUserExists() === false) {

            $GodAdmin = (new User());
            $GodAdmin
                ->setEmail(self::STATIC_EMAIL)
                ->setPassword(Hash::make('pleasechangeme'))
                ->setName('Amin Eshtiaghi')
                ->save();

        }
    }

    private function checkIsMainUserExists()
    {
        return (new User())
            ->where(User::COLUMN_EMAIL, '=', self::STATIC_EMAIL)
            ->exists();
    }
}
