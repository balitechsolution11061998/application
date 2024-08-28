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
            'icon'           => 'fas', // Font Awesome solid icons
            'iconName'       => 'fa-tachometer-alt', // Icon for items
            'iconPath'       => 7,
            'route'          => 'home',
        ],
        [
            'label'          => 'Banner',
            'type'           => 'item',
            'route'          => 'banner.index', // Change this to the appropriate route for the banner
            'active'         => [],
            'permission'     => [],
            'permissionType' => 'gate',
            'icon'           => 'fas',
            'iconName'       => 'fa-image', // Icon for Banner (image icon)
            'iconPath'       => '',
        ],
        [
            'label'          => 'Category',
            'type'           => 'item',
            'route'          => 'category.index',
            'active'         => [],
            'permission'     => [],
            'permissionType' => 'gate',
            'icon'           => 'fas',
            'iconName'       => 'fa-folder', // Icon for Banner (image icon)
            'iconPath'       => '',
        ],
        [
            'label'          => 'Brands',
            'type'           => 'item',
            'route'          => 'brands.index', // Replace with the correct route name for the brands list
            'active'         => [], // Specify active routes or patterns related to brands
            'permission'     => [], // Define any permissions required to access the brands menu
            'permissionType' => 'gate', // Type of permission check, e.g., 'gate' or 'role'
            'icon'           => 'fas', // FontAwesome icon for brands (e.g., 'fas fa-tags')
            'iconName'       => 'fa-tags', // Just the icon name if needed separately
            'iconPath'       => '', // If using a custom icon path or image, specify it here
        ],
        [
            'label'          => 'Product',
            'type'           => 'item',
            'route'          => 'product.index',
            'active'         => [],
            'permission'     => [],
            'permissionType' => 'gate',
            'icon'           => 'fas',
            'iconName'       => 'fa-box', // Icon for Product
            'iconPath'       => '', // If needed, specify the path for custom icons
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




    ],
];
