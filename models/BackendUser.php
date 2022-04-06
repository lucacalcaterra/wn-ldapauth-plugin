<?php

namespace LucaCalcaterra\LdapAuth\Models;

// Authenticates the user for logging in and manages the remember token
// Initial compatibility with Illumninate.Auth
use LdapRecord\Laravel\Auth\HasLdapUser;
use Backend\Models\User as BackendUserModel;
use Backend\Models\UserGroup;
use LdapRecord\Laravel\Auth\LdapAuthenticatable;
use LdapRecord\Laravel\Auth\AuthenticatesWithLdap;

class BackendUser extends BackendUserModel implements LdapAuthenticatable
{
    use AuthenticatesWithLdap, HasLdapUser;

    /**
     * The column name of the "remember me" token.
     *
     * @var string
     */
    protected $rememberTokenName = 'persist_code';

    /**
     * Override - after user create assign role (and others)
     * @return void
     */
    public function afterCreate()
    {
        // assign default role
        $this->role_id = Settings::get('role_default');
        // assign default group
        if (Settings::get('group_default_check')) {
            $group = UserGroup::where('id', Settings::get('group_default'))->first();
            $group->users()->save($this);
        }
        // save
        $this->forceSave();
    }
}
