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
            'dashboard-system' => 's',
            'dashboard' => 's',
            'home'=>'c,r,u,d',
            'permissions' => 'c,r,u,d',
            'roles' => 'c,r,u,d',
            'users' => 's,c,r,u,d',
            'supplier' => 's,c,r,u,d',
            'store' => 's,c,r,u,d',
            'toplevelsupplier' => 's',
            'filter' => 'su',
            'pricelist' => 'c,r,u,d,a,up,re,s',
            'po' => 'c,r,u,d,a,up,dw,sy,s',
            'rcv' => 'c,r,u,d,a,up,dw,sy,s',
            'rtv' => 'c,r,u,d,a,s',
            'report' => 's',
            'rtv' => 's',
            'tanda-terima' => 's',
            'usermanagement'=>'s',
            'faq'=>'s',
            'service-level'=>'s',
            'history'=>'log',
            'user'=>'s',
            'roles'=>'s',
            'permissions'=>'s',
            'data-kependudukan'=>'s',
        ],
        'superadminektp' => [
            'data-kependudukan' => 's',
        ],
        'administrator' => [
            'dashboard' => 's',
            'home'=>'c,r,u,d',
            'permissions' => 'c,r,u,d',
            'roles' => 'c,r,u,d',
            'user' => 'c,r,u,d',
            'supplier' => 's,c,r,u,d',
            'store' => 's,c,r,u,d',
            'toplevelsupplier' => 's',
            'filter' => 'su',
            'pricelist' => 'c,r,u,d,a,up,re,s',
            'po' => 'c,r,u,d,a,up,dw,sy,s',
            'rcv' => 'c,r,u,d,a,up,dw,sy,s',
            'rtv' => 'c,r,u,d,a,s',
            'report' => 's',
            'rtv' => 's',
            'tanda-terima' => 's',
            'usermanagement'=>'s',
            'faq'=>'s',
            'service-level'=>'s',
            'history'=>'log',
        ],
        'it' => [
            'users' => 'c,r,u,d',
            'profile' => 'r,u',
        ],
        'acct' => [
            'profile' => 'r,u',
        ],
        'wh' => [
            'dashboard' => 's',
            'pricelist' => 's',
            'filter' => 'su',
            'po' => 's',
            'rcv' => 's',
            'rtv' => 's',
            'tanda-terima' => 's',
        ],
        'opr' => [
            'dashboard' => 's',
            'filter' => 'su',
            'po' => 's',
            'rcv' => 's',
            'rtv' => 's',
        ],
        'supplier' => [
            'dashboard' => 's',
            'pricelist' => 's,c,r,u,d,up',
            'po' => 's',
            'rcv' => 's',
            'rtv' => 's',
            'tanda-terima' => 's',
            'faq'=>'s',
        ],
        'admin-md-region' => [
            'pricelist' => 'r,u,d,a,re',
        ],
        'md-region' => [
        ],
        'md-ho' => [
        ],
        'data-analyst-md' => [
        ],
        'bdm' => [
        ],
        'md-manager' => [
        ],
        'vendor' => [
        ],
        'customer' => [
        ],
    ],

    'permissions_map' => [
        's' => 'show',
        'c' => 'create',
        'a' => 'approve',
        'r' => 'read',
        'up'=>'upload',
        'u' => 'update',
        'd' => 'delete',
        'dw' => 'download',
        'sy' => 'syncront',
        'su' => 'supplier',
        're' => 'reject',

        'log' => 'login',

    ],
];
