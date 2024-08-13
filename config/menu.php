<?php

return [
    # Menus
    'KT_MENU_MODE' => 'auto', /** 'manual' or 'auto' */

    'KT_MENUS' => [
        [
            'label'          => 'Log Dashboard',
            'type'           => 'item',
            'permission'     => [],
            'permissionType' => 'gate',
            'icon'           => 'fas',
            'iconName'       => 'fa-history', // Changed icon to reflect logging
            'iconPath'       => 7,
            'route'          => 'home.log',
        ],
        [
            'label'          => 'Supplier Dashboard',
            'type'           => 'item',
            'permission'     => ['dashboardsupplier-show'],
            'permissionType' => 'gate',
            'icon'           => 'fas',
            'iconName'       => 'fa-truck-loading', // Changed icon to reflect supplier operations
            'iconPath'       => 8,
            'route'          => 'home',
        ],
        [
            'label'          => 'CBT Dashboard',
            'type'           => 'item',
            'permission'     => ['dashboardcbt-show'],
            'permissionType' => 'gate',
            'icon'           => 'fas',
            'iconName'       => 'fa-laptop-code', // Changed icon to reflect CBT (Computer-Based Testing)
            'iconPath'       => 9,
            'route'          => 'home.cbt',
        ],
        [
            'label'          => 'Presence Dashboard',
            'type'           => 'item',
            'permission'     => ['dashboardpresensi-show'],
            'permissionType' => 'gate',
            'icon'           => 'fas',
            'iconName'       => 'fa-user-check', // Changed icon to reflect presence/attendance
            'iconPath'       => 10,
            'route'          => 'home.epresensi',
        ],




        [
            'label'          => 'Items',
            'type'           => 'item',
            'permission'     => ['items-show'],
            'permissionType' => 'gate',
            'icon'           => 'ki',
            'iconName'       => 'ki-element-11',
            'iconPath'       => 7,
            'route'          => 'items.index',
        ],

        [
            'label'          => 'Price Change',
            'type'           => 'item',
            'permission'     => ['cost_change-show'],
            'permissionType' => 'gate',
            'icon'           => 'ki',
            'iconName'       => 'ki-element-11',
            'iconPath'       => 6,
            'route'          => 'price-change.index',
        ],
        [
            'label'          => 'PO',
            'type'           => 'item',
            'permission'     => ['po-show'],
            'permissionType' => 'gate',
            'icon'           => 'ki',
            'iconName'       => 'ki-element-11',
            'iconPath'       => 5,
            'route'          => 'po.index',
        ],
        [
            'label'          => 'Monitoring Presensi',
            'type'           => 'item',
            'permission'     => ['monitoring-show'],
            'permissionType' => 'gate',
            'icon'           => 'fas', // updated icon
            'iconName'       => 'fa-tv', // updated icon name
            'iconPath'       => 5,
            'route'          => 'monitoring-presensi.index',
        ],
        [
            'label'          => 'Data Izin/Sakit',
            'type'           => 'item',
            'permission'     => ['monitoring-show'],
            'permissionType' => 'gate',
            'icon'           => 'fas', // Font Awesome Solid icon set
            'iconName'       => 'fa-calendar-check', // Font Awesome icon for "leave" or "permission"
            'iconPath'       => 5,
            'route'          => 'izin.index',
        ],
        [
            'label'          => 'Paket Soal',
            'type'           => 'item',
            'permission'     => ['paketsoal-show'],
            'permissionType' => 'gate',
            'icon'           => 'fas',
            'iconName'       => 'fa-book',
            'iconPath'       => '',
            'route'          => 'paket-soal.index',
        ],
        [
            'label'          => 'Manajement Soal',
            'type'           => 'item',
            'permission'     => ['manajementsoal-show'],
            'permissionType' => 'gate',
            'icon'           => 'fas',
            'iconName'       => 'fa-book',
            'iconPath'       => '', // Usually not needed for Font Awesome icons
            'route'          => 'soal.index', // Ensure this route exists in your web.php routes file
        ],
        [
            'label'          => 'Ujian',
            'type'           => 'item',
            'permission'     => ['ujian-show'],
            'permissionType' => 'gate',
            'icon'           => 'fas',
            'iconName'       => 'fa-book',
            'iconPath'       => '', // Usually not needed for Font Awesome icons
            'route'          => 'ujian.index', // Ensure this route exists in your web.php routes file
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
                    'label'          => 'User',
                    'type'           => 'item',
                    'route'          => 'users.index',
                    'active'         => ['users-show'],
                    'permission'     => ['users-show'],
                    'permissionType' => 'gate',
                    'icon'           => 'dot',
                ],

            ]
        ],

        [
            'label'          => 'Settings',
            'type'           => 'item',
            'permission'     => ['settings-show'],
            'permissionType' => 'gate',
            'icon'           => 'ki',
            'iconName'       => 'ki-wrench',
            'iconPath'       => 7,
            'route'          => 'settings.priceChange.index',
        ],
        [
            'label'          => 'Jam Kerja',
            'type'           => 'item',
            'permission'     => ['jamkerja-show'],
            'permissionType' => 'gate',
            'icon'           => 'fas', // Combine icon type and name
            'iconName'       => 'fa-clock', // Just the icon name
            'iconPath'       => 7,
            'route'          => 'jam_kerja.index',
        ],
        [
            'label'          => 'Department',
            'type'           => 'item',
            'permission'     => ['department-show'],
            'permissionType' => 'gate',
            'icon'           => 'fas',
            'iconName'       => 'fa-warehouse',
            'iconPath'       => 7,
            'route'          => 'departments.index',
        ],
        [
            'label'          => 'Kantor Cabang',
            'type'           => 'item',
            'permission'     => ['kantorcabang-show'],
            'permissionType' => 'gate',
            'icon'           => 'fas',
            'iconName'       => 'fa-building',
            'iconPath'       => 7,
            'route'          => 'kantor_cabang.index',
        ],
        [
            'label'          => 'Cuti',
            'type'           => 'item',
            'permission'     => ['cuti-show'],
            'permissionType' => 'gate',
            'icon'           => 'fas',
            'iconName'       => 'fa-clipboard-check',
            'iconPath'       => 7,
            'route'          => 'cuti.index',
        ],





        [
            'label'          => 'Data Jadwal',
            'type'           => 'item',
            'permission'     => [],
            'permissionType' => 'gate',
            'icon'           => 'fas',
            'iconName'       => 'fa-calendar-alt', // Ikon untuk Jadwal
            'iconPath'       => 7,
            'route'          => 'jadwal.index',
        ],
        [
            'label'          => 'Data Guru',
            'type'           => 'item',
            'permission'     => [],
            'permissionType' => 'gate',
            'icon'           => 'fas',
            'iconName'       => 'fa-chalkboard-teacher', // Ikon untuk Guru
            'iconPath'       => 7,
            'route'          => 'guru.index',
        ],
        [
            'label'          => 'Kelas',
            'type'           => 'item',
            'permission'     => ['kelas-show'],
            'permissionType' => 'gate',
            'icon'           => 'fas',
            'iconName'       => 'fa-chalkboard', // Ikon untuk Kelas (berbeda dari Guru)
            'iconPath'       => 7,
            'route'          => 'kelas.index',
        ],
        [
            'label'          => 'Siswa',
            'type'           => 'item',
            'route'          => 'siswa.index',
            'active'         => ['siswa-show'],
            'permission'     => ['siswa-show'],
            'permissionType' => 'gate',
            'icon'           => 'fas',
            'iconName'       => 'fa-user-graduate', // Ikon berbeda untuk Siswa
            'iconPath'       => '',
        ],
        [
            'label'          => 'Mata Pelajaran',
            'type'           => 'item',
            'permission'     => ['matapelajaran-show'],
            'permissionType' => 'gate',
            'icon'           => 'fas',
            'iconName'       => 'fa-book-open', // Ikon berbeda untuk Mata Pelajaran
            'iconPath'       => 7,
            'route'          => 'mata-pelajaran.index',
        ],
        [
            'label'          => 'User',
            'type'           => 'item',
            'route'          => 'users.cbt',
            'active'         => [],
            'permission'     => [],
            'permissionType' => 'gate',
            'icon'           => 'fas',
            'iconName'       => 'fa-users-cog', // Ikon berbeda untuk User
            'iconPath'       => '',
        ],
        [
            'label'          => 'Absensi Guru',
            'type'           => 'item',
            'route'          => 'guru.absensi',
            'active'         => [],
            'permission'     => [],
            'permissionType' => 'gate',
            'icon'           => 'fas',
            'iconName'       => 'fa-chalkboard-teacher',
            'iconPath'       => '',
        ],
        [
            'label'          => 'Nilai Ulangan',             // Label for the menu item
            'type'           => 'item',                      // Type of the menu
            'route'          => 'ulangan.create',            // The route name for this menu item (replace with your actual route)
            'active'         => [],                          // An array of routes or patterns to mark as active
            'permission'     => [],                          // The permission(s) required to view this item (adjust as needed)
            'permissionType' => 'gate',                      // Type of permission check
            'icon'           => 'fas',                       // The icon set being used (e.g., 'fas' for Font Awesome Solid)
            'iconName'       => 'fa-pencil-alt',             // The specific icon to display for "Nilai Ulangan"
            'iconPath'       => '',                          // Path to custom icons, typically empty for Font Awesome
        ],
        [
            'label'          => 'Nilai Raport',               // Label for the menu item
            'type'           => 'item',                       // Type of the menu
            'route'          => 'raport.rapot-kelas',              // The route name for this menu item (replace with your actual route)
            'active'         => ['nilairaport-show'],                           // An array of routes or patterns to mark as active
            'permission'     => ['nilairaport-show'],                           // The permission(s) required to view this item (adjust as needed)
            'permissionType' => 'gate',                       // Type of permission check
            'icon'           => 'fas',                        // The icon set being used (e.g., 'fas' for Font Awesome Solid)
            'iconName'       => 'fa-book',                    // The specific icon to display for "Nilai Raport"
            'iconPath'       => '',                           // Path to custom icons, typically empty for Font Awesome
        ],
        [
            'label'          => 'Deskripsi Predikat',                   // Label for the menu item
            'type'           => 'item',                       // Type of the menu
            'route'          => 'predikat',             // The route name for this menu item (replace with your actual route)
            'active'         => ['predikat-show'],                           // An array of routes or patterns to mark as active
            'permission'     => ['predikat-show'],                           // The permission(s) required to view this item (adjust as needed)
            'permissionType' => 'gate',                       // Type of permission check
            'icon'           => 'fas',                        // The icon set being used (e.g., 'fas' for Font Awesome Solid)
            'iconName'       => 'fa-star',                    // The specific icon to display for "Predikat"
            'iconPath'       => '',                           // Path to custom icons, typically empty for Font Awesome
        ],
        [
            'label'          => 'Pengumuman',                   // Label for the menu item
            'type'           => 'item',                         // Type of the menu
            'route'          => 'pengumuman',             // The route name for this menu item (replace with your actual route)
            'active'         => ['pengumuman-show'],                             // An array of routes or patterns to mark as active
            'permission'     => ['pengumuman-show'],                             // The permission(s) required to view this item (adjust as needed)
            'permissionType' => 'gate',                         // Type of permission check
            'icon'           => 'fas',                          // The icon set being used (e.g., 'fas' for Font Awesome Solid)
            'iconName'       => 'fa-bullhorn',                  // The specific icon to display for "Pengumuman"
            'iconPath'       => '',                             // Path to custom icons, typically empty for Font Awesome
        ],
        [
            'label'          => 'Absen',                       // Label for the menu item
            'type'           => 'item',                        // Type of the menu
            'route'          => 'guru.absen.harian',                 // The route name for this menu item (replace with your actual route)
            'active'         => ['absenharianguru-show'],                            // An array of routes or patterns to mark as active
            'permission'     => ['absenharianguru-show'],                            // The permission(s) required to view this item (adjust as needed)
            'permissionType' => 'gate',                        // Type of permission check
            'icon'           => 'fas',                         // The icon set being used (e.g., 'fas' for Font Awesome Solid)
            'iconName'       => 'fa-calendar-check',           // The specific icon to display for "Absen"
            'iconPath'       => '',                            // Path to custom icons, typically empty for Font Awesome
        ],
        [
            'label'          => 'Jadwal',                  // Label for the menu item
            'type'           => 'item',                         // Type of the menu
            'route'          => 'jadwal.guru.jadwal',                  // The route name for this menu item (replace with your actual route)
            'active'         => ['jadwal-show'],                             // An array of routes or patterns to mark as active
            'permission'     => ['jadwal-show'],                             // The permission(s) required to view this item (adjust as needed)
            'permissionType' => 'gate',                         // Type of permission check
            'icon'           => 'fas',                          // The icon set being used (e.g., 'fas' for Font Awesome Solid)
            'iconName'       => 'fa-calendar-alt',              // The specific icon to display for "Jadwal Guru"
            'iconPath'       => '',                             // Path to custom icons, typically empty for Font Awesome
        ],
        [
            'label'          => 'Nilai',                       // Label for the "Nilai" menu item
            'type'           => 'item',                        // Type of the menu
            'route'          => 'nilai.index',                 // The route name for this menu item
            'active'         => ['nilai-show'],                            // An array of routes or patterns to mark as active
            'permission'     => ['nilai-show'],                            // The permission(s) required to view this item
            'permissionType' => 'gate',                        // Type of permission check
            'icon'           => 'fas',                         // The icon set being used
            'iconName'       => 'fa-clipboard-list',           // The specific icon to display for "Nilai"
            'iconPath'       => '',                            // Path to custom icons, typically empty for Font Awesome
        ],
        [
            'label'          => 'Nilai Raport',                // Label for the "Nilai Raport" menu item
            'type'           => 'item',                        // Type of the menu
            'route'          => 'nilai.index',                // The route name for this menu item
            'active'         => ['nilairaport-show'],                            // An array of routes or patterns to mark as active
            'permission'     => ['nilairaport-show'],                            // The permission(s) required to view this item
            'permissionType' => 'gate',                        // Type of permission check
            'icon'           => 'fas',                         // The icon set being used
            'iconName'       => 'fa-book',                     // The specific icon to display for "Nilai Raport"
            'iconPath'       => '',                            // Path to custom icons, typically empty for Font Awesome
        ],

        // [
        //     'label'          => 'Ruang Kelas',
        //     'type'           => 'item',
        //     'permission'     => [],
        //     'permissionType' => 'gate',
        //     'icon'           => 'fas',
        //     'iconName'       => 'fa-user-tie', // Updated icon class
        //     'iconPath'       => 7,
        //     'route'          => 'ruang-kelas.index',
        // ]



    ],
];
