<?php

class AdminDatabaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($data = [])
    {
        DB::table('admin_users')->insert([
            'name' => $data['login'] ?? 'admin',
            'login' => $data['login'] ?? 'admin',
            'password' => Hash::make($data['password'] ?? 'admin'),
        ]);

        DB::table('admin_resources')->insert([
            'name' => 'test',
            'traits' => json_encode([
                'Activable' => true,
                'Translatable' => true,
            ]),
            'data' => json_encode([
                'timestamps' => true,
                'softDeletes' => true,
            ]),
            'fields' => json_encode([
                [
                    'name' => 'id',
                    'type' => 'increment',
                    'params' => []
                ]
            ]),
        ]);
    }
}