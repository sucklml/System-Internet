<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 17/09/2017
 * Time: 11:06
 */

namespace App\Http\Controllers;
use App\Dispositivo;
use App\Repositories\UsuarioRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Repositories\DispositivoRepository;

class DispositivoController extends Controller
{
    private $DispositivoRep;
    private $UsuarioRepo;
    public function __construct(UsuarioRepository $UsuarioRepo,DispositivoRepository $DispositivoRep)
    {
        $this->UsuarioRepo = $UsuarioRepo;
        $this->DispositivoRep = $DispositivoRep;
    }

    public function index(Request $request)
    {
        $Usuario = (string)$request->session()->get('user', 'default');
        $Password =   (string)$request->session()->get('pws', 'default');
        $user = $this->UsuarioRepo->validateUser($Usuario,$Password);
        if(count($user)== 0 ){
            return redirect('/');
        }
        $item = $this->f_castAccesos($user);

        //Yordy del user traes el id XD y listas los proveedores;

        //Funcion para resaltar el acceso
        $item = $this->f_accesoresaltado($item,$request);
        $mobj_data = new \stdClass();
        $mobj_data->Dispositivo = $this->DispositivoRep->flst_Listar();
        $mobj_data->Dispositivos = json_encode(collect(Dispositivo::where('Estado',1)->get())->toArray());
     //return dd($mobj_data);
    // return view('modulos.Mikrotik.mikrotiks',['item'=>$item],['data'=> $mobj_data]);
        return view('modulos.Mikrotik.mikrotiks',['item'=>$item],['data'=> $mobj_data]);
        //return $this->ProveedorRep->fls_Proveedores();
    }
    public function create(Request $request)
    {
        $itemMikrotik = new Dispositivo();
        $itemMikrotik->Nombre = $request->input('nombre');
        $itemMikrotik->Ip = $request->input('ip');
        $itemMikrotik->Puerto = $request->input('puerto');
        $itemMikrotik->User = $request->input('user');
        $itemMikrotik->Password = $request->input('password');
        $itemMikrotik->Estado = 1;
        $this->DispositivoRep->flst_Guardar($itemMikrotik);
        return redirect('/pagMikrotik');
    }
    public function destroy(Request $request)
    {
        $mint_idProveedor = (int)$request->idDispositivo;
        $itemMikrotik = Dispositivo::find($mint_idProveedor);
        $itemMikrotik->Estado = null;
        $this->DispositivoRep->Actualizar($itemMikrotik);
        return redirect('/pagMikrotik');
    }
    public function update(Request $request)
    {
        $itemMikrotik = new Dispositivo();
        $itemMikrotik->Nombre = $request->input('nombre');
        $itemMikrotik->Ip = $request->input('ip');
        $itemMikrotik->Puerto = $request->input('puerto');
        $itemMikrotik->User = $request->input('user');
        $itemMikrotik->Password = $request->input('password');
        $this->DispositivoRep->flst_Guardar($itemMikrotik);
        return redirect('/pagMikrotik');
    }
//    public function editar(Request $request)
//  {

       // $idDispositivo =$request->input('idDispositivo');
        ///$mint_idDispositivo = (int)$request->idDispositivo;
       // $itemMikrotik = Dispositivo::find($mint_idDispositivo);
        //$itemMikrotik->Estado = null;
        //$this->DispositivoRep->Actualizar($itemMikrotik);
        ///$    mobj_data2 = new \stdClass();
        ///$mobj_data2->Dispositivo = $this->DispositivoRep->fobj_Obtner($mint_idDispositivo);
        //return $mobj_data2;
        ///return redirect($mobj_data2);
        //return redirect('/pagMikrotik');
            //redirect('mcrypt_module_close(td).Mikrotik.mikrotik',['item'=>$item],['data'=>$mobj_data2]);
     //$mint_idDispositivo = (int)$request->idDispositivo;
    // $data = Data::find ( $req->idDispositivo );
    /// $mobj_data2 = new \stdClass();
     ///   $mobj_data2->Dispositivo = $this->DispositivoRep->fobj_Obtner($data);
      //7  return response ()->json ( $mobj_data2 );
        

        //funciona 
  //      $term = $request->input('idDispositivo');
         //$term = 2;
  //    foreach ($request as $paciente) {
          //$array= array('value' => $paciente->idDispositivo);
//$mint_idDispositivo $request->ajax();
//$mint_idDispositivo=$request['idDispositivo'];
    //    }
       
    //      $dispo = new Dispositivo();
         //  $dispo->idDispositivo = $request[1];
         // $dispo = $this->DispositivoRep->fobj_Obtner($term);
  //$data = Dispositivo::find('idDispositivo',$term)->get();
 // $sen['success'] = true;
 // $sen['result'] = $mobj_data2->toArray();
//  return response()->json($dispo);
  //asta aca funciona
//return dd($request);
//return dd(Request::json());
  //  }
}
