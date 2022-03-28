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
        'show_all_posts' => ['boolean'],
    ];
}
