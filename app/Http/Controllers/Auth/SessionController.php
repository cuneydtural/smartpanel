<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use Sentinel;
use App\Http\Requests;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Redirect;
use Session;
use Mockery\Exception;

class SessionController extends Controller
{

    public function getLogin()
    {
        return view('admin.auth.login');
    }

    /**
     * @param LoginRequest $request
     * @return string
     */
    public function postLogin(LoginRequest $request)
    {

        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        try {
            if ($user = Sentinel::authenticate($credentials, false)) {
                return Redirect::intended(route('admin.dashboard.index'));
            } else {
                Session::flash('message', 'Lütfen kimlik bilgilerinizi kontrol ediniz!');
                return redirect()->route('admin.login');
            }
        }
        catch (NotActivatedException $e) {
            Session::flash('message', 'Üyeliğiniz henüz aktif edilmedi!');
            return redirect()->route('admin.login');
        }
        catch (ThrottlingException $e) {
            Session::flash('message', 'Çok sık hatalı giriş yaptınız. Lütfen 5 dakika sonra tekrar deneyiniz.');
            return redirect()->route('admin.login');
        }
        catch (Exception $e) {
            Session::flash('message', $e->getMessage());
            return redirect()->route('admin.login');
        }
        return redirect()->route('admin.login');
    }

    /**
     *
     */
    public function getLogout()
    {
        Sentinel::logout();
        return redirect()->route('admin.login');
    }

    public function forbidden()
    {
        return view('admin.errors.forbidden');
    }

}
