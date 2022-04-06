<?php

namespace LucaCalcaterra\LdapAuth\Models;

use Winter\Storm\Database\Model;

class Settings extends Model
{
    use \Winter\Storm\Database\Traits\Validation;

    public $implement = ['System.Behaviors.SettingsModel'];

    public $settingsCode = 'lucacalcaterra_ldapauth_settings';

    public $settingsFields = 'fields.yaml';

    public $rules = [
        'host' => 'required',
        'port' => 'required',
        'user' => 'required',
        'password' => 'required'
    ];

    public function getRoleDefaultOptions($value, $formData)
    {
        return \Backend\Models\UserRole::all()->pluck('name', 'id');
    }

    public function getGroupDefaultOptions($value, $formData)
    {
        return \Backend\Models\UserGroup::all()->pluck('name', 'id');
    }
}
