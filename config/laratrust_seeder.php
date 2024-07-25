<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'superadministrator' => [
            'dashboard' => 's',
            'users' => 's',
            'permissions' => 's,c',
            'roles' => 's,c',
            'items' => 's',
            'cost_change' => 'a,s',
            'po' => 's',
            'monitoring' => 's',
            'roles' => 's',
            'settings' => 's',
            'jamkerja' => 's',
            'department' => 's',
            'kantorcabang' => 's',
            'cuti' => 's',
            'soal' => 's',
        ],
        'karyawan' => [
            'dashboard' => 's',
        ],
        // 'user' => [
        //     'profile' => 'r,u',
        // ],
        // 'role_name' => [
        //     'module_1_name' => 'c,r,u,d',
        // ],
    ],

    'permissions_map' => [
        'a'=>'approval',
        'm'=>'menu',
        's'=>'show',
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
    ],
];
