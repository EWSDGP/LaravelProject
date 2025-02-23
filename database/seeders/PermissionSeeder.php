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
        $permission = [
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
        ];
        foreach($permission as $key =>$permission){
                Permission::create(['name'=>$permission]);
        }

    }
}
