<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            "user-list",
            "user-create",
            "user-edit",
            "user-delete",
            "role-list",
            "role-create",
            "role-edit",
            "role-delete",
            "category-list",
            "category-create",
            "category-edit",
            "category-delete",
            "department-list",
            "department-create",
            "department-edit",
            "department-delete",
            "closure_date-list",
            "closure_date-create",
            "closure_date-edit",
            "closure_date-delete",
            "idea-list",
            "idea-submit",
            "idea-edit",
            "idea-delete",
            "comment-list",
            "comment-submit",
            "comment-edit",
            "comment-delete",
            "download-ideas"
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission,'guard_name' => 'web']);
        }
    }
}
