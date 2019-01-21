<?php

namespace App\Http\Controllers;

use App\Repositories\MikrotikRepository;
use Illuminate\Http\Request;

use App\Http\Requests;

class MikrotikController extends Controller
{
    protected $MikroRepo;

    public function __construct(MikrotikRepository $repo)
    {
        $this->MikroRepo = $repo;
    }

    public function getData($date){
        //$dat = $this->MikroRepo->getDataForHora();
        $dat = $this->MikroRepo->getDataforDay();

        return response()->json($dat);
    }
    public function index()
    {
        return $this->MikroRepo->getDataforDay();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
