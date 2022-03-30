<?php

namespace LucaCalcaterra\LdapAuth\Models;

// Authenticates the user for logging in and manages the remember token
// Initial compatibility with Illumninate.Auth
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Backend\Models\User as BackendUserModel;
use LdapRecord\Laravel\Auth\AuthenticatesWithLdap;
use LdapRecord\Laravel\Auth\HasLdapUser;
use LdapRecord\Laravel\Auth\LdapAuthenticatable;

class BackendUser extends BackendUserModel implements LdapAuthenticatable
{
    use AuthenticatesWithLdap, HasLdapUser;

    /**
     * The column name of the "remember me" token.
     *
     * @var string
     */
    protected $rememberTokenName = 'persist_code';
}
