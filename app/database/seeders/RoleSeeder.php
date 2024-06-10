<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\RoleOptions;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'admin',
                'description' => 'Администратор сайта (супер - админ)',
                'is_default' => false,
                'options' => [
                    'is_access_admin_part' => true,
                ],
            ],
            [
                'name' => 'user',
                'description' => 'Пользователь',
                'is_default' => true,
                'options' => [
                    'is_access_admin_part' => false,
                ],
            ],
        ];

        if (count($data) > 0) {
            foreach ($data as $role) {
                $db_role = Role::where([
                    'name' => $role['name'],
                    'description' => $role['description'],
                ])->first();
                if (!$db_role) {
                    $db_role = new Role();
                    $db_role->name = $role['name'];
                    $db_role->description = $role['description'];
                }
                $db_role->is_default = $role['is_default'];
                $db_role->save();

                $this->command->info('Роль ' . $role['name'] . ' добавлена');

                if (isset($role['options'])) {
                    $db_role_options = RoleOptions::where([
                        'role_id' => $db_role->id,
                    ])->first();
                    if (!$db_role_options) {
                        $db_role_options = new RoleOptions();
                        $db_role_options->role_id = $db_role->id;
                    }
                    $db_role_options->is_access_admin_part = $role['options']['is_access_admin_part'];
                    $db_role_options->save();

                    $this->command->info('Правила для роли ' . $role['name'] . ' добавлены');
                }
            }
        }
    }
}
