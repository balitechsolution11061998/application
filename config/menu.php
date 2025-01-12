<?php

return [
    # Menus
    'KT_MENU_MODE' => 'auto',
    /** 'manual' or 'auto' */
    'KT_MENUS' => [
        // Dashboard menu item (previously Profile)
        [
            'label'          => 'Dashboard System',               // Menu label updated to Dashboard
            'type'           => 'item',                    // Type (item represents a clickable menu option)
            'permission'     => ['show-dashboard-system'],                        // Permissions required to view this item
            'permissionType' => 'gate',                    // Permission type (gate or policy)
            'icon'           => 'fas',                     // Font Awesome Solid icons (FA class)
            'iconName'       => 'fa-tachometer-alt',        // Updated icon for the dashboard (optional)
            'route'          => 'dashboard-system.index',    // Route updated to dashboard (replace with your dashboard route)
            'active'         => [],                        // Define conditions when this item is active
            'iconPath'       => 4,
        ],
        [
            'label'          => 'Dashboard PO',               // Label for the menu (e.g., Dashboard PO)
            'type'           => 'item',                       // Represents a single clickable menu item
            'permission'     => [],        // Permissions required to access the menu
            'permissionType' => 'gate',                       // Use Laravel's gate for permission checks
            'icon'           => 'fas',                        // Font Awesome Solid icon class
            'iconName'       => 'fa-chart-bar',               // Icon representing a dashboard/analytics view
            'route'          => 'dashboard-po.index',               // Route for the PO Dashboard
            'active'         => ['dashboard-po.*'], // Active states for the menu
            'iconPath'       => 4,                            // Optional: Custom icon path (if applicable)
        ],
        [
            'label'          => 'Dashboard Pilkada',           // Menu label
            'type'           => 'item',                        // Type of menu (item represents a clickable menu option)
            'permission'     => [],                            // Permissions required to view this item
            'permissionType' => 'gate',                        // Permission type (gate or policy)
            'icon'           => 'fas',                         // Font Awesome Solid icons (FA class)
            'iconName'       => 'fa-vote-yea',                 // Updated icon for Pemilu (vote icon)
            'route'          => 'dashboard-pilkada.index',                        // Route to the dashboard
            'active'         => [],                            // Define conditions when this item is active
            'iconPath'       => 4,                             // Additional metadata (optional)
        ],
        [
            'label'          => 'Activity Logs',                // Menu label
            'type'           => 'item',                         // Type of menu (item represents a clickable menu option)
            'permission'     => [],                             // Permissions required to view this item
            'permissionType' => 'gate',                         // Permission type (gate or policy)
            'icon'           => 'fas',                          // Font Awesome Solid icons (FA class)
            'iconName'       => 'fa-list-alt',                  // Icon for Activity Logs
            'route'          => 'activity-logs.index',          // Route to the activity logs
            'active'         => [],                             // Define conditions when this item is active
            'iconPath'       => 4,                              // Additional metadata (optional)
        ],
        [
            'label'          => 'Price Change',                  // Menu label for Price Change
            'type'           => 'item',                          // Type (item represents a clickable menu option)
            'permission'     => [],                              // Permissions required to view this item
            'permissionType' => 'gate',                          // Permission type (gate or policy)
            'icon'           => 'fas',                           // Font Awesome Solid icons (FA class)
            'iconName'       => 'fa-tag',                        // Icon for the price change section
            'route'          => 'price-change.index',  // Route for the price change page
            'active'         => ['price-change.*'],// Define conditions when this item is active
            'iconPath'       => 4,                               // Path for the icon (if applicable)
        ],

        [
            'label'          => 'Purchase Order',               // Menu label for Purchase Order
            'type'           => 'item',                          // Type (item represents a clickable menu option)
            'permission'     => [],                              // Permissions required to view this item
            'permissionType' => 'gate',                          // Permission type (gate or policy)
            'icon'           => 'fas',                           // Font Awesome Solid icons (FA class)
            'iconName'       => 'fa-shopping-cart',              // Icon for the purchase order section
            'route'          => 'purchase-orders.index',         // Route for the purchase order index page
            'active'         => ['purchase-orders.*'],           // Define conditions when this item is active (e.g., all purchase order routes)
            'iconPath'       => 4,                               // Path for the icon (if applicable)
        ],
        [
            'label'          => 'Receiving',                     // Menu label for Receiving
            'type'           => 'item',                          // Type (item represents a clickable menu option)
            'permission'     => [],                              // Permissions required to view this item
            'permissionType' => 'gate',                          // Permission type (gate or policy)
            'icon'           => 'fas',                           // Font Awesome Solid icons (FA class)
            'iconName'       => 'fa-box',                       // Updated icon for the Receiving section
            'route'          => 'receiving.index',               // Route for the receiving index page
            'active'         => ['receiving.*'],                 // Define conditions when this item is active (e.g., all receiving routes)
            'iconPath'       => 4,                               // Path for the icon (if applicable)
        ],
        [
            'label'          => 'Item Supplier',                  // Menu label for Item Supplier
            'type'           => 'item',                           // Type (item represents a clickable menu option)
            'permission'     => [],                               // Permissions required to view this item
            'permissionType' => 'gate',                           // Permission type (gate or policy)
            'icon'           => 'fas',                            // Font Awesome Solid icons (FA class)
            'iconName'       => 'fa-user-tie',                   // Icon for the item supplier section
            'route'          => 'item-suppliers.index',          // Route for the item supplier index page
            'active'         => ['item-suppliers.*'],            // Define conditions when this item is active (e.g., all item supplier routes)
            'iconPath'       => 4,                                // Path for the icon (if applicable)
        ],
        [
            'label'          => 'Supplier',                       // Menu label for Supplier
            'type'           => 'item',                           // Type (item represents a clickable menu option)
            'permission'     => [],                               // Permissions required to view this item
            'permissionType' => 'gate',                           // Permission type (gate or policy)
            'icon'           => 'fas',                            // Font Awesome Solid icons (FA class)
            'iconName'       => 'fa-user-tag',                   // Updated icon for the supplier section
            'route'          => 'suppliers.index',          // Route for the item supplier index page
            'active'         => ['suppliers.*'],            // Define conditions when this item is active (e.g., all item supplier routes)
            'iconPath'       => 4,                                // Path for the icon (if applicable)
        ],
        [
            'label'          => 'Store',                          // Menu label for Store
            'type'           => 'item',                           // Type (item represents a clickable menu option)
            'permission'     => [],                               // Permissions required to view this item
            'permissionType' => 'gate',                           // Permission type (gate or policy)
            'icon'           => 'fas',                            // Font Awesome Solid icons (FA class)
            'iconName'       => 'fa-store',                       // Updated icon for the store section
            'route'          => 'stores.index',                   // Route for the item store index page
            'active'         => ['stores.*'],                     // Define conditions when this item is active (e.g., all item store routes)
            'iconPath'       => 4,                                // Path for the icon (if applicable)
        ],

        [
            'label'          => 'Members',                        // Menu label for Members
            'type'           => 'item',                           // Type (item represents a clickable menu option)
            'permission'     => [],                               // Permissions required to view this item
            'permissionType' => 'gate',                           // Permission type (gate or policy)
            'icon'           => 'fas',                            // Font Awesome Solid icons (FA class)
            'iconName'       => 'fa-users',                       // Updated icon for the members section
            'route'          => 'members.index',                  // Route for the item members index page
            'active'         => ['members.*'],                    // Define conditions when this item is active (e.g., all item members routes)
            'iconPath'       => 4,                                // Path for the icon (if applicable)
        ],

        // Pages section heading
        [
            'label' => 'Pages',
            'type'  => 'heading' // This represents a section heading (non-clickable)
        ],

        [
            'label'          => 'Master Data',        // Main menu label
            'type'           => 'item',                   // Type item (clickable menu item)
            'permission'     => [],                       // Permissions (empty implies no restrictions)
            'permissionType' => 'gate',                   // Permission type (gate or policy)
            'icon'           => 'fas',                    // Font Awesome icons class
            'iconName'       => 'fa-database',               // Icon name for this main item
            'iconPath'       => 4,                        // Optional icon size/path
            'children'       => [                         // Sub-items (children)



                // Adding "Tahun Pelajaran" (School Year) Menu
                [
                    'label'          => 'Tahun Pelajaran',  // New menu for managing academic years
                    'type'           => 'item',             // Item type
                    'route'          => 'tahun-pelajaran.index',  // Route for managing academic years
                    'active'         => [],                 // Define when this item is active
                    'permission'     => [],   // Permissions required to access this menu item
                    'permissionType' => 'gate',             // Gate-based permission checking
                    'icon'           => 'fas',
                    'iconName'       => 'fa-calendar',
                    'iconPath'       => 4,
                ],
            ]
        ],


        // Management User menu item with sub-items (children)
        [
            'label'          => 'Management User',       // Main menu label
            'type'           => 'item',                  // Type item (clickable menu item)
            'permission'     => ['user-management'],                      // Permissions (empty implies no restrictions)
            'permissionType' => 'gate',                  // Permission type (gate or policy)
            'icon'           => 'fas',                   // Font Awesome icons class
            'iconName'       => 'fa-users',              // Icon name for this main item
            'iconPath'       => 4,                       // Optional icon size/path
            'children'       => [                        // Sub-items (children)
                [
                    'label'          => 'User',          // Child item label
                    'type'           => 'item',          // Type item (clickable)
                    'route'          => 'users.index', // Route for user management
                    'active'         => [],              // Define when this item is active
                    'permission'     => [],              // Permissions required for this item
                    'permissionType' => 'gate',          // Permission type
                    'icon'           => 'dot',           // Optional small icon for child items
                ],
                [
                    'label'          => 'Roles',         // Child item for managing roles
                    'type'           => 'item',
                    'route'          => 'roles.index',  // Route for role management
                    'active'         => [],
                    'permission'     => [],
                    'permissionType' => 'gate',
                    'icon'           => 'dot',           // Dot icon for sub-items
                ],
                [
                    'label'          => 'Permissions',
                    'type'           => 'item',
                    'route'          => 'permissions.index',
                    'active'         => [],
                    'permission'     => [],
                    'permissionType' => 'gate', // Using Laravel's gate for permission checking
                    'icon'           => 'dot',
                ],

            ]
        ],

        // Profile item (this one can be removed if it's redundant)
        [
            'label'          => 'Profile',
            'type'           => 'item',
            'permission'     => ['read-profile'],
            'permissionType' => 'gate',
            'icon'           => 'fas',
            'iconName'       => 'fa-user',
            'route'          => 'users.profile',
            'active'         => [],
            'iconPath'       => 4,

        ],
    ],


];
