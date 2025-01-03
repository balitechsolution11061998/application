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
            'dashboard-po' => 's',
            'dashboard-system' => 's',
            'management' => 'usr',
            'roles' => 'c,r,u,d',
            'permissions' => 'c,r,u,d',
            'users' => 'c,r,u,d',
            'profile' => 'r,u',
            'home' => 's,u',
        ],
        'administrator' => [
            'dashboard' => 's',
            'users' => 'c,r,u,d',
            'profile' => 'r,u',
        ],
        'user' => [
            'profile' => 'r,u',
        ],
        'admin_md_region' => [
            'users' => 'c,r,u,d',
            'profile' => 'r,u',
            'md_region' => 'c,r,u,d',
        ],
        'acct' => [
            'finance' => 'c,r,u,d',
            'profile' => 'r,u',
        ],
        'bdm' => [
            'business' => 'c,r,u,d',
            'profile' => 'r,u',
        ],
        'data_analyst_md' => [
            'data' => 'c,r,u,d',
            'profile' => 'r,u',
        ],
        'it' => [
            'technology' => 'c,r,u,d',
            'profile' => 'r,u',
        ],
        'md_ho' => [
            'head_office' => 'c,r,u,d',
            'profile' => 'r,u',
        ],
        'md_manager' => [
            'management' => 'c,r,u,d',
            'profile' => 'r,u',
        ],
        'md_region' => [
            'region' => 'c,r,u,d',
            'profile' => 'r,u',
        ],
        'opr' => [
            'operations' => 'c,r,u,d',
            'profile' => 'r,u',
        ],
        'supplier' => [
            'profile' => 'r,u',
        ],
        'wh' => [
            'warehouse' => 'c,r,u,d',
            'profile' => 'r,u',
        ],
        // New store role added
        'store' => [
            'inventory' => 'c,r,u,d',
            'orders' => 'c,r,u,d',
            'profile' => 'r,u',
        ],
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
        's' => 'show',
        'usr' => 'user',
    ],
];
