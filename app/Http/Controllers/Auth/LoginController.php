<?php

namespace App\Http\Controllers\Auth;
use App\User;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function credentials(Request $request)
    {
        $login = $request->input($this->username());

        $field = 'username';
        return [
            $field => $login,
            'password' => $request->input('password')
        ];
    }

    public function username()
    {
        return 'login';
    }

    public function getInfo(Request $request)
	{
		$username = $request["data"];

		if ($username == "")
		{
			$result = "";
			return Response::json( $result);
		}
		else {
			$query = "SELECT U.id, U.active, U.contador FROM users U WHERE U.username = '".$username."' OR U.email = '".$username."' ";
				$result = DB::select($query);
				return Response::json( $result);
			}

    }
    
    public function Contador(Request $request)
    {
        $data = $request->all();

        $user = User::where('id',$data["user"])->first();
        if($data['contador'] == 10){
            $user->update(['contador' => 0 , 'active' => 0]);

            return Response::json(['result' => 'ok']);
            
            //return redirect('/login')->with('MensajeError','El usuario ha sido bloqueado por muchos intentos');
        }

        else {
            $user->update(['contador' => $data['contador'] ]);
            
            return Response::json(['result' => 'ok']);
        }
           
    }


    public function userExiste()
	{
		$dato = Input::get("login");
        $query = User::where("username",$dato)
                    ->orWhere('email', $dato)               
                    ->get();
		$contador = count($query);
		if ($contador == 0)
		{
			return 'true';
		}
		else
		{
			return 'false';
		}
	}

}
