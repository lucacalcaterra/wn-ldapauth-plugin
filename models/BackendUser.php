<?php

namespace LucaCalcaterra\LdapAuth\Models;

// Authenticates the user for logging in and manages the remember token
// Initial compatibility with Illumninate.Auth
use Backend\Models\UserGroup;
use Illuminate\Auth\Authenticatable;
use LdapRecord\Laravel\Auth\HasLdapUser;
use Backend\Models\User as BackendUserModel;
use Backend\Models\UserRole;
use LdapRecord\Laravel\Auth\LdapAuthenticatable;
use LdapRecord\Laravel\Auth\AuthenticatesWithLdap;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

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
        $role = UserRole::where('code', UserRole::CODE_PUBLISHER)->first();
        $this->role_id = $role->id;
        $this->forceSave();
    }
}
