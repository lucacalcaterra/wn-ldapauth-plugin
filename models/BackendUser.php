<?php

namespace LucaCalcaterra\LdapAuth\Models;

// Authenticates the user for logging in and manages the remember token
// Initial compatibility with Illumninate.Auth
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Backend\Models\User as BackendUserModel;


class BackendUser extends BackendUserModel implements AuthenticatableContract
{
    use Authenticatable,
        HasApiTokens,
        Notifiable;

    /**
     * The column name of the "remember me" token.
     *
     * @var string
     */
    protected $rememberTokenName = 'persist_code';
}
