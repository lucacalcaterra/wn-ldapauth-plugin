<?php

use LucaCalcaterra\LdapAuth\Models\Settings;

return [

    'packages' => [
        'illuminate-auth' => [
            'providers' => [
                '\Illuminate\Auth\AuthServiceProvider',
            ],
            'config_namespace' => 'auth',

            'config' => [
                /*
                |--------------------------------------------------------------------------
                | Authentication Defaults
                |--------------------------------------------------------------------------
                |
                | This option controls the default authentication "guard" and password
                | reset options for your application. You may change these defaults
                | as required, but they're a perfect start for most applications.
                |
                */

                'defaults' => [
                    'guard' => 'web',
                    'passwords' => 'ldap',
                ],

                /*
                |--------------------------------------------------------------------------
                | Authentication Guards
                |--------------------------------------------------------------------------
                |
                | Next, you may define every authentication guard for your application.
                | Of course, a great default configuration has been defined for you
                | here which uses session storage and the Eloquent user provider.
                |
                | All authentication drivers have a user provider. This defines how the
                | users are actually retrieved out of your database or other storage
                | mechanisms used by this application to persist your user's data.
                |
                | Supported: "session", "token", "passport"
                |
                */

                'guards' => [
                    'web' => [
                        'driver' => 'session',
                        'provider' => 'ldap',
                    ],
                ],

                /*
                |--------------------------------------------------------------------------
                | User Providers
                |--------------------------------------------------------------------------
                |
                | All authentication drivers have a user provider. This defines how the
                | users are actually retrieved out of your database or other storage
                | mechanisms used by this application to persist your user's data.
                |
                | If you have multiple user tables or models you may configure multiple
                | sources which represent each model / table. These sources may then
                | be assigned to any extra authentication guards you have defined.
                |
                | Supported: "database", "eloquent"
                |
                */

                'providers' => [
                    'users' => [
                        'driver' => 'eloquent',
                        'model' => \LucaCalcaterra\LdapAuth\Models\BackendUser::class,
                    ],

                    'ldap' => [
                        'driver' => 'ldap',
                        'model' => LdapRecord\Models\ActiveDirectory\User::class,
                        'rules' => [],
                        'database' => [
                            'model' => \LucaCalcaterra\LdapAuth\Models\BackendUser::class,
                            'sync_passwords' => true,
                            'sync_attributes' => [
                                'first_name' => 'givenName',
                                'last_name' => 'sn',
                                'login' => 'samaccountname',
                                'email' => 'mail',
                            ],
                            'sync_existing' => [
                                'login' => 'samaccountname',
                            ],
                        ],
                    ],
                ],
            ],
        ],

        'ldap' => [
            'providers' => [
                '\LdapRecord\Laravel\LdapAuthServiceProvider',
                '\LdapRecord\Laravel\LdapServiceProvider',
            ],
            'config_namespace' => 'ldap',

            'config' => [
                'default' => env('LDAP_CONNECTION', 'default'),

                'connections' => [
                    'default' => [
                        'hosts' => [env('LDAP_HOST', Settings::get('host'))],
                        'username' => env('LDAP_USERNAME', Settings::get('user')),
                        'password' => env('LDAP_PASSWORD', Settings::get('password')),
                        'port' => env('LDAP_PORT', 389),
                        'base_dn' => env('LDAP_BASE_DN', Settings::get('base_dn')),
                        'timeout' => env('LDAP_TIMEOUT', 5),
                        'use_ssl' => env('LDAP_SSL', boolval(Settings::get('use_ssl'))),
                        'use_tls' => env('LDAP_TLS', boolval(Settings::get('use_tls'))),
                    ]
                ]
            ]
        ],
    ],
];
