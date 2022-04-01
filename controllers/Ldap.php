<?php

namespace LucaCalcaterra\LdapAuth\Controllers;

use BackendAuth;
use DebugBar\DebugBar;

use Backend\Models\User;
use Backend\Models\AccessLog;

use Backend\Classes\Controller;
use System\Classes\UpdateManager;
use Illuminate\Support\Facades\Auth;

use Winter\Storm\Exception\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use LucaCalcaterra\LdapAuth\Models\Settings as Settings;
use Backend,  Config, Flash, Input, Lang, Request, Session;

class Ldap extends Backend\Classes\Controller
{

    use AuthenticatesUsers;

    /**
     * @var array Public controller actions
     */
    protected $publicActions = ['signin'];

    public function __construct()
    {
        parent::__construct();
    }
    public function login()
    {
        return 'login';
    }

    // protected function credentials(Request $request)
    // {
    //     return [
    //         'mail' => $request->email,
    //         'password' => $request->password,
    //     ];
    // }

    public function signin()
    {

        /** test */
        $credentials = [
            'samaccountname' => Input::get('login'),
            'password' => Input::get('password'),
        ];

        //dd(Auth::attempt($credentials));
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            BackendAuth::login($user, true);

            UpdateManager::instance()->update();
            AccessLog::add($user);
            return Backend::redirectIntended('backend');
        }


        # CHECK SETTINGS ARE DEFINED
        // $this->checkSettings(['host', 'port', 'user', 'password']);

        // # CREATE GOOGLE CLIENT
        // $client = new Google_Client();
        // $client->setClientId(Settings::get('google_client_id'));
        // $client->setClientSecret(Settings::get('google_client_secret'));
        // $client->setRedirectUri(Backend::url('martin/ssologin/google'));
        // $client->setScopes('email');

        // # HANDLE LOGOUTS
        // if (Input::has('logout')) {
        //     Session::forget('access_token');
        //     return;
        // }

        // # AUTHENTICATE GOOGLE USER
        // if (Input::has('code')) {
        //     $client->authenticate(Input::get('code'));
        //     Session::put('access_token', $client->getAccessToken());
        // }

        // # SET ACCESS TOKEN OR GET A NEW ONE
        // if (Session::has('access_token')) {
        //     $client->setAccessToken(Session::get('access_token'));
        // } else {
        //     $authUrl = $client->createAuthUrl();
        //     // Redirect::to() doesn't work here. Send header manually.
        //     header("Location: $authUrl");
        //     exit;
        // }

        // # PARSE USER DETAILS
        // if ($client->getAccessToken()) {
        //     $token_data = $client->verifyIdToken();
        //     Session::put('access_token', $client->getAccessToken());
        // }

        // # FORGET ACCESS TOKEN
        // Session::forget('access_token');

        // # CHECK MAIL EXISTS
        // if (!isset($token_data['email'])) {

        //     # RECORD FAILED LOGIN
        //     $log = new Log;
        //     $log->provider = 'Google';
        //     $log->result   = 'failed';
        //     $log->email    = $email;
        //     $log->ip       = Request::getClientIp();
        //     $log->save();

        //     Flash::error(trans('martin.ssologin::lang.errors.google.invalid_user'));
        //     return Backend::redirect('backend/auth/signin');
        // }

        // # FIND USER BY EMAIL
        // $email = $token_data['email'];
        // $user  = User::where('email', $email)->first();

        // # IF NO USER, GET BACK TO LOGIN SCREEN
        // if (!$user) {

        //     # RECORD FAILED LOGIN
        //     $log = new Log;
        //     $log->provider = 'Google';
        //     $log->result   = 'failed';
        //     $log->email    = $email;
        //     $log->ip       = Request::getClientIp();
        //     $log->save();

        //     Flash::error(trans('martin.ssologin::lang.errors.google.invalid_user'));
        //     return Backend::redirect('backend/auth/signin');
        // }

        // # LOGIN USER ON BACKEND
        // BackendAuth::login($user, true);

        // # RECORD SUCCESSFUL LOGIN
        // $log = new Log;
        // $log->provider = 'Google';
        // $log->result   = 'successful';
        // $log->user_id  = $user->id;
        // $log->email    = $email;
        // $log->ip       = Request::getClientIp();
        // $log->save();

        // // Load version updates
        // UpdateManager::instance()->update();

        // // Log the sign in event
        // AccessLog::add($user);

        // if (Input::has('login')) {
        //     Session::forget('access_token');
        //     return;
        // }

        // // Redirect to the intended page after successful sign in
        // return Backend::redirectIntended('backend');
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
