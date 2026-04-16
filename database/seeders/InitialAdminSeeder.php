<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class InitialAdminSeeder extends Seeder
{
    public function run(): void
    {
        $clientName = env('INITIAL_ADMIN_CLIENT_NAME', 'Velinex Labs');
        $adminName = env('INITIAL_ADMIN_NAME', 'Velinex Admin');
        $adminEmail = env('INITIAL_ADMIN_EMAIL', 'admin@velinexlabs.com');
        $adminPassword = env('INITIAL_ADMIN_PASSWORD', 'ChangeMeNow!2026');

        $client = Client::firstOrCreate(
            ['slug' => Str::slug($clientName)],
            ['name' => $clientName, 'status' => 'active']
        );

        User::updateOrCreate(
            ['email' => $adminEmail],
            [
                'name' => $adminName,
                'password' => Hash::make($adminPassword),
                'client_id' => $client->id,
            ]
        );
    }
}

