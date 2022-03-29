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
                            'model' => App\Models\User::class,
                            'sync_passwords' => true,
                            'sync_attributes' => [
                                'name' => 'cn',
                                'username' => 'samaccountname',
                                'email' => 'mail',
                            ],
                            'sync_existing' => [
                                'username' => 'samaccountname',
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
            'config_namespace' => 'auth',

            'config' => [
                'connections' => [
                    'default' => []
                ]
            ]
            // 'aliases' => [
            //     'Passport' => '\Laravel\Passport\Passport',
            // ],
        ],
    ],
];
