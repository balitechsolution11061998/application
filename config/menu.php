<?php

return [
    // Menu Settings
    'KT_MENU_MODE' => 'auto', // 'manual' or 'auto'

    'KT_MENUS' => [
        [
            'label'          => 'Dashboard',
            'type'           => 'item',
            'permission'     => [],
            'permissionType' => 'gate',
            'icon'           => 'fas',
            'iconName'       => 'fa-tachometer-alt', // Font Awesome icon for dashboard
            'iconPath'       => 9,
            'url'            => '#',
            'children'       => [
                [
                    'label'          => 'Log Dashboard',
                    'type'           => 'item',
                    'permission'     => ['logdashboard-show'],
                    'permissionType' => 'gate',
                    'icon'           => 'fas',
                    'iconName'       => 'fa-history', // Icon for logging
                    'iconPath'       => 7,
                    'route'          => 'home.log',
                ],
                [
                    'label'          => 'Supplier Dashboard',
                    'type'           => 'item',
                    'permission'     => ['dashboardsupplier-show'],
                    'permissionType' => 'gate',
                    'icon'           => 'fas',
                    'iconName'       => 'fa-truck-loading', // Icon for supplier operations
                    'iconPath'       => 8,
                    'route'          => 'home',
                ],
                [
                    'label'          => 'CBT Dashboard',
                    'type'           => 'item',
                    'permission'     => ['dashboardcbt-show'],
                    'permissionType' => 'gate',
                    'icon'           => 'fas',
                    'iconName'       => 'fa-laptop-code', // Icon for CBT (Computer-Based Testing)
                    'iconPath'       => 9,
                    'route'          => 'home.cbt',
                ],
                [
                    'label'          => 'Presence Dashboard',
                    'type'           => 'item',
                    'permission'     => ['dashboardpresensi-show'],
                    'permissionType' => 'gate',
                    'icon'           => 'fas',
                    'iconName'       => 'fa-user-check', // Icon for presence/attendance
                    'iconPath'       => 10,
                    'route'          => 'home.epresensi',
                ],
                [
                    'label'          => 'User Dashboard',
                    'type'           => 'item',
                    'permission'     => ['dashboard-user'],
                    'permissionType' => 'gate',
                    'icon'           => 'fas', // Font Awesome solid icons
                    'iconName'       => 'fa-user-check', // Icon for user check (presence/attendance)
                    'iconPath'       => 10,
                    'route'          => 'home.dashboarduser',
                ],
            ],
        ],
        [
            'label'          => 'Items',
            'type'           => 'item',
            'permission'     => ['items-show'],
            'permissionType' => 'gate',
            'icon'           => 'fas', // Font Awesome solid icons
            'iconName'       => 'fa-box', // Icon for items
            'iconPath'       => 7,
            'route'          => 'items.index',
        ],
        [
            'label'          => 'Price Change',
            'type'           => 'item',
            'permission'     => ['cost_change-show'],
            'permissionType' => 'gate',
            'icon'           => 'fas', // Font Awesome solid icons
            'iconName'       => 'fa-tags', // Icon for price tags
            'iconPath'       => 6,
            'route'          => 'price-change.index',
        ],
        [
            'label'          => 'PO & RCV & TT',
            'type'           => 'item',
            'permission'     => ['po-show'],
            'permissionType' => 'gate',
            'icon'           => 'fas', // Font Awesome solid icons
            'iconName'       => 'fa-shipping-fast', // Icon for shipping/receiving
            'iconPath'       => 5,
            'route'          => 'po.index',
        ],
        [
            'label'          => 'Purchase Order',
            'type'           => 'item',
            'permission'     => ['po-show'],
            'permissionType' => 'gate',
            'icon'           => 'fas', // Font Awesome solid icons
            'iconName'       => 'fa-file-alt', // Icon for purchase order document
            'iconPath'       => 5,
            'route'          => 'order.index',
        ],

        [
            'label'          => 'User',
            'type'           => 'item',
            'permission'     => ['users-show'],
            'permissionType' => 'gate',
            'icon'           => 'fas',
            'iconName'       => 'fa-users',
            'iconPath'       => 3,
            'children'       => [
                [
                    'label'          => 'Permissions',
                    'type'           => 'item',
                    'route'          => 'permissions.index',
                    'active'         => ['permissions-show'],
                    'permission'     => ['permissions-show'],
                    'permissionType' => 'gate',
                    'icon'           => 'dot',
                ],
                [
                    'label'          => 'Roles',
                    'type'           => 'item',
                    'route'          => 'roles.index',
                    'active'         => ['roles-show'],
                    'permission'     => ['roles-show'],
                    'permissionType' => 'gate',
                    'icon'           => 'dot',
                ],
                [
                    'label'          => 'Users',
                    'type'           => 'item',
                    'route'          => 'users.index',
                    'active'         => ['users-show'],
                    'permission'     => ['users-show'],
                    'permissionType' => 'gate',
                    'icon'           => 'dot',
                ],
            ],
        ],
        [
            'label'          => 'Pulsa',
            'type'           => 'item',
            'route'          => 'product.index',
            'active'         => [],
            'permission'     => [],
            'permissionType' => 'gate',
            'icon'           => 'fas',
            'iconName'       => 'fa-mobile-alt', // Icon for Pulsa (mobile phone icon)
            'iconPath'       => '',
        ],
    ],
];
