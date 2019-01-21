<?php

namespace App\Http\Controllers\Auth;

use App\Repositories\UsuarioRepository;
use App\User;
use Symfony\Component\HttpFoundation\Request;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;
    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';
    protected $UserRepo;
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(UsuarioRepository $repository)
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
        $this->UserRepo = $repository;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function index(Request $request){

        $Usuario = (string)$request->session()->get('user', 'default');
        $Password =   (string)$request->session()->get('pws', 'default');

        $user = $this->UserRepo->validateUser( $Usuario,$Password);
        if(count($user)>0){
            return redirect('/pagCliente');
        }
        return view('auth.login');

    }
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'apellido' => 'required',
            'telefono' => 'required',
            'direccion' => 'required'
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'name' => $data['name'],
            'Nombre' => $data['nombre'],
            'apellido' => $data['apellido'],
            'telefono' => $data['telefono'],
            'direccion' => $data['direccion'],
        ]);
    }

    public function getLogin(){
    }
    public function store(Request $r){
      $user = $this->UserRepo->validateUser($r['user'],$r['pws']);
        if(count($user)==0){
            return redirect('/');
        }
        $r->session()->put('user',$r['user']);
        $r->session()->put('pws',$r['pws']);
        return redirect('/pagCliente');
    }

    public function salir(Request $r){
        $r->session()->put('user',"");
        $r->session()->put('pws',"");
        return redirect('/');
    }

}
