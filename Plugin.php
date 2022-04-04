<?php

namespace LucaCalcaterra\LdapAuth;

use App;
use Config;
use Backend;
use Session;
use Event, View, Flash;
use Backend\Models\UserRole;
use System\Classes\PluginBase;
use System\Classes\CombineAssets;
use Illuminate\Foundation\AliasLoader;
use LucaCalcaterra\LdapAuth\Models\Settings;

/**
 * LdapAuth Plugin Information File
 */
class Plugin extends PluginBase
{
    public $elevated = true;

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Ldap Authentication',
            'description' => 'Provide LDAP Authentication for Backend',
            'author'      => 'LucaCalcaterra',
            'icon'        => 'icon-plug',
            'homepage'    => 'https://github.com/lucacalcaterra/wn-ldapauth-plugin'
        ];
    }

    public function registerSettings()
    {
        return [
            'ldap' => [
                'label' => 'Ldap',
                'description' => 'Ldap Settings',
                'category' => 'system::lang.system.categories.system',
                'icon' => 'icon-plug',
                'class' => 'Lucacalcaterra\LdapAuth\Models\Settings',
                'order' => 500,
                'keywords' => 'ldap settings',
                'permissions' => ['lucacalcaterra.ldapauth.manage_settings']
            ]
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
        // Setup required packages
        $this->bootPackages();

        // disable password confirmation validation
        \Backend\Models\User::extend(function ($model) {
            if (!$model instanceof  \Backend\Models\User) {
                return;
            }

            $model->bindEvent('model.beforeValidate', function () use ($model) {
                $model->rules = [
                    'password_confirmation' => null
                ];
            });
        });

        // override view in case of custom login

        // \Backend\Controllers\Auth::extend(function ($controller) {
        //     if (\Backend\Classes\BackendController::$action == 'signin') {
        //         $controller->addCss(CombineAssets::combine(['ldapauth.css'], plugins_path() . '/lucacalcaterra/ldapauth/assets/css/'));
        //     }
        // });

        Event::listen('backend.auth.extendSigninView', function ($controller) {
            // return View::make("lucacalcaterra.ldapauth::login");

            // if must be override default auth page
            if (Settings::get('')) {
                $this->hookSigninForm($controller);
            }
        });
    }

    protected function hookSigninForm($controller)
    {
        $controller->addJs('/plugins/lucacalcaterra/ldapauth/assets/js/override-auth.js');
        $message = Session::get('message');
        if (!empty($message)) {
            Flash::error($message);
        }
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        // return []; // Remove this line to activate

        return [
            'lucacalcaterra.ldapauth.some_permission' => [
                'tab' => 'LdapAuth',
                'label' => 'Some permission',
                //'roles' => [UserRole::CODE_DEVELOPER, UserRole::CODE_PUBLISHER],
            ],
        ];
    }

    /**
     * Boots (configures and registers) any packages found within this plugin's packages.load configuration value
     *
     * @see https://luketowers.ca/blog/how-to-use-laravel-packages-in-october-plugins
     * @author Luke Towers <wintercms@luketowers.ca>
     */
    public function bootPackages()
    {
        // Get the namespace of the current plugin to use in accessing the Config of the plugin
        $pluginNamespace = str_replace('\\', '.', strtolower(__NAMESPACE__));

        // Instantiate the AliasLoader for any aliases that will be loaded
        $aliasLoader = AliasLoader::getInstance();

        // Get the packages to boot
        $packages = Config::get($pluginNamespace . '::config.packages');

        // Boot each package
        foreach ($packages as $name => $options) {
            // Setup the configuration for the package, pulling from this plugin's config
            if (!empty($options['config']) && !empty($options['config_namespace'])) {
                Config::set($options['config_namespace'], $options['config']);
            }

            // Register any Service Providers for the package
            if (!empty($options['providers'])) {
                foreach ($options['providers'] as $provider) {
                    App::register($provider);
                }
            }

            // Register any Aliases for the package
            if (!empty($options['aliases'])) {
                foreach ($options['aliases'] as $alias => $path) {
                    $aliasLoader->alias($alias, $path);
                }
            }
        }
    }
}
