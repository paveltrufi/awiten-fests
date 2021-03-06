<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Mail;
use App\Mail\NewUserWelcome;
use App\Mail\AdminConfirmManager;
use App\Notifications\AdminConfirmUser;
use App\Notifications\UserRegistered;
use App\Notifications\UserAutoConfirm;
use App\Notifications\UserConfirmed;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin/entities';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'username' => 'required|max:20|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'username' => $data['username'],
            'token' => str_random(25),
            'typeOfUser' =>  $data['tipo'],
        ]);
    }


    public function register(Request $request){
        $this->validator($request->all())->validate();
        $info = $request->all();
        if($request->has('tipo-usuario')){
          $info['tipo'] = 'manager';
        } else{
          $info['tipo'] = 'promoter';
        }
        $data = $this->create($info)->toArray();  
        $content = [ 'token' => $data['token'], 'user' => $data['username'], 'name' => $data['name'], 'email' => $data['email']];
        $user = User::find($data['id']);
        if($data['typeOfUser'] == 'promoter'){
            $admin = User::where('typeOfUser', '=', 'admin')->first();
            $admin->notify(new AdminConfirmUser($content));
            $user->notify(new UserRegistered());
        } else {
            $user->notify(new UserAutoConfirm($content));
        }
        
        return redirect('/register')->with('registro-status', 'Te has registrado correctamente. Solo falta la autorización.');
    }

    public function confirmation($token){
            if(!is_null($token) && $token != ''){
                $user = User::where('token', $token)->first();
            if(!is_null($user)){
                $user->confirmed = true;
                $user->token = '';
                $user->notify(new UserConfirmed());
                $user->save();
                return redirect('login')->with('status', 'Tu activación está completada');
            }
        }
        return redirect('/login')->with('status','Algo ha ido mal en la activacion');
    }
}
