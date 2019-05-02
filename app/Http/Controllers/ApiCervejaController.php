<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cerveja;
use JWTAuth;

class ApiCervejaController extends Controller
{

    protected $user;

    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->user
            ->cervejas()
            ->get(['nome', 'IBU', 'ABV', 'SRM', 'EBC'])
            ->toArray();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'nome' => 'required|unique:cervejas|min:3|max:100',
            'IBU' => 'required|numeric|min:0|max:60',
            'ABV' => 'required|numeric|min:0|max:60',
            'EBC' => 'required|numeric|min:0|max:90',
            'SRM' => 'required'
        ]);

        $cerveja = new Cerveja;
        $cerveja->nome = $request->nome;
        $cerveja->IBU = $request->IBU;
        $cerveja->ABV = $request->ABV;
        $cerveja->EBC = $request->EBC;
        $cerveja->SRM = $request->SRM;
        $cerveja->descricao = $request->descricao;
        $cerveja->copo_id = $request->copo_id;
        $cerveja->estilo_id = $request->estilo_id;
        $cerveja->color_id = $request->color_id;

        

        if ($this->user->cervejas()->save($cerveja)) {
            return response()->json([
                'success' => true,
                'cerveja' => $cerveja,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, product could not be added',
            ], 500);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $cerveja = $this->user->cervejas()->find($id);
        if (!$cerveja) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, cerveja with id ' . $id . ' cannot be found',
            ], 400);
        }

        return $cerveja;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $product = $this->user->products()->find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, product with id ' . $id . ' cannot be found',
            ], 400);
        }

        $updated = $product->fill($request->all())
            ->save();

        if ($updated) {
            return response()->json([
                'success' => true,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, product could not be updated',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $product = $this->user->products()->find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, product with id ' . $id . ' cannot be found',
            ], 400);
        }

        if ($product->delete()) {
            return response()->json([
                'success' => true,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Product could not be deleted',
            ], 500);
        }
    }
}
