<?php

namespace LucaCalcaterra\LdapAuth\Controllers;

use BackendAuth;

use Backend\Models\AccessLog;

use Backend\Classes\Controller;
use System\Classes\UpdateManager;

use Illuminate\Support\Facades\Auth as LdapAuth;
use Winter\Storm\Auth\AuthenticationException;
use Winter\Storm\Exception\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use LucaCalcaterra\LdapAuth\Models\Settings as Settings;
use Backend, Flash, Input, Lang;

class Ldap extends Controller
{

    use AuthenticatesUsers;

    /**
     * @var array Public controller actions
     */
    protected $publicActions = ['signin'];


    public function signin()
    {



        try {
            // get credentials from login form
            $username = Input::get('login');
            $password = Input::get('password');

            // builtin auth - check user
            $user = BackendAuth::findUserByLogin($username);
            if (isset($user) && (!isset($user->domain))) {
                $credentials = [
                    'login' => $username,
                    'password' => $password,
                ];
                BackendAuth::authenticate($credentials, true);
            } else {
                // ldap auth
                $credentials = [
                    'samaccountname' => $username,
                    'password' => $password,
                ];
                $auth = LdapAuth::attempt($credentials);
                if (!$auth) {
                    throw new AuthenticationException('Invalid credentials or LDAP Connection Issue');
                };
                $user = LdapAuth::user();

                if ($user) {
                    BackendAuth::login($user, true);
                } else {
                    throw new AuthenticationException("LDAP error: User not found");
                }
            }
            UpdateManager::instance()->update();
            AccessLog::add($user);
            return Backend::redirectIntended('backend');
        } catch (AuthenticationException $ex) {
            Flash::error($ex->getMessage());
            return Backend::redirect('backend');
        }
    }


    #########################################################################################
    #   CHECK PLUGIN SETTINGS EXISTS
    #########################################################################################
    private function checkSettings($settings = array())
    {
        foreach ($settings as $setting) {
            if (Settings::get($setting) == '') {
                throw new ValidationException([
                    'code' => Lang::get('martin.ssologin::lang.errors.google.generic') . Lang::get('martin.ssologin::lang.errors.google.' . $setting . '_blank')
                ]);
            }
        }
    }
}
