<?php

namespace JhInstaller;

return [

    //controllers
    'controllers' => [
        'factories' => [
            'JhInstaller\Controller\Install'  => 'JhInstaller\Controller\Factory\InstallControllerFactory',
        ]
    ],

    //service manager
    'service_manager' => [
        'factories' => [
            'JhInstaller\Install\Installer'   => 'JhInstaller\Install\Factory\InstallerFactory',
        ],
    ],

    //console routes
    'console' => [
        'router' => [
            'routes' => [
                'installer' => [
                    'options'   => [
                        'route'     => 'install',
                        'defaults'  => [
                            'controller' => 'JhInstaller\Controller\Install',
                            'action'     => 'install'
                        ],
                    ],
                ],
            ],
        ],
    ],
];
