<?php return [
    // If null, value will be pulled from app.debug

    'packages' => [
        'illuminate-auth' => [
            'providers' => [
                '\Illuminate\Auth\AuthServiceProvider',
            ],

            // 'aliases' => [
            //     'Sentry'   => '\Sentry\Laravel\Facade',
            // ],

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

                    // 'api' => [
                    //     'driver' => 'passport',
                    //     'provider' => 'users',
                    // ],
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
                                //'email' => 'mail', //no altrimenti eccezione duplicato su id username
                            ],
                        ],
                    ],
                    // 'users' => [
                    //     'driver' => 'database',
                    //     'table' => 'users',
                    // ],
                ],

                /*
                |--------------------------------------------------------------------------
                | Resetting Passwords
                |--------------------------------------------------------------------------
                |
                | You may specify multiple password reset configurations if you have more
                | than one user table or model in the application and you want to have
                | separate password reset settings based on the specific user types.
                |
                | The expire time is the number of minutes that the reset token should be
                | considered valid. This security feature keeps tokens short-lived so
                | they have less time to be guessed. You may change this as needed.
                |
                */

                // **NOTE**: May not be currently necessary as October implements this separately
                //
                // 'passwords' => [
                //     'users' => [
                //         'provider' => 'users',
                //         'table' => 'backend_users_password_resets',
                //         'expire' => 60,
                //     ],
                // ],
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
                        'hosts' => [env('LDAP_HOST', '127.0.0.1')],
                        'username' => env('LDAP_USERNAME', 'cn=user,dc=local,dc=com'),
                        'password' => env('LDAP_PASSWORD', 'secret'),
                        'port' => env('LDAP_PORT', 389),
                        'base_dn' => env('LDAP_BASE_DN', 'dc=local,dc=com'),
                        'timeout' => env('LDAP_TIMEOUT', 5),
                        'use_ssl' => env('LDAP_SSL', false),
                        'use_tls' => env('LDAP_TLS', false),
                    ]
                ]
            ]
            // 'aliases' => [
            //     'Passport' => '\Laravel\Passport\Passport',
            // ],
        ],
    ],
];
