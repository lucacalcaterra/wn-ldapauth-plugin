<?php

namespace LucaCalcaterra\LdapAuth;

use Backend;
use Backend\Models\UserRole;
use System\Classes\PluginBase;

/**
 * LdapAuth Plugin Information File
 */
class Plugin extends PluginBase
{
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
            'icon'        => 'icon-leaf'
        ];
    }

    public function registerSettings()
    {
        return [
            'ldap' => [
                'label' => 'Ldap',
                'description' => 'Ldap Settings',
                'category' => 'system::lang.system.categories.system',
                'icon' => 'icon-pencil',
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
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'LucaCalcaterra\LdapAuth\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'lucacalcaterra.ldapauth.some_permission' => [
                'tab' => 'LdapAuth',
                'label' => 'Some permission',
                'roles' => [UserRole::CODE_DEVELOPER, UserRole::CODE_PUBLISHER],
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'ldapauth' => [
                'label'       => 'LdapAuth',
                'url'         => Backend::url('lucacalcaterra/ldapauth/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['lucacalcaterra.ldapauth.*'],
                'order'       => 500,
            ],
        ];
    }
}
