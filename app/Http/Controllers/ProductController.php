<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(Product $produto)
    {
        $this->produtos = $produto;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          $tasksManeger = $this->produtos->all();
        return response()->json($tasksManeger, 200);
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
        $request->validate($this->produtos->rules(), $this->produtos->feedback());

        $produto = $this->produtos->create([

            'status' => $request->status,
            'imported_t' => $request->imported_t,
            'product_name' => $request->product_name,
            'quantity' => $request->quantity,
            'categories' => $request->categories,
            'cities' => $request->cities
        ]);
        return response()->json($produto , 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $produto = $this->produtos->find($id);
        if ( $produto === null) {
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404); // json
        }
        return response()->json($produto, 201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $produto = $this->produtos->find($id);

        if(  $produto === null) {
            return response()->json(['erro' => 'Impossível realizar a atualização. O recurso solicitado não existe'], 404);
        }

        if($request->method() === 'PATCH') {

            $regrasDinamicas = array();

            //percorrendo todas as regras definidas no Model
            foreach($produto>rules() as $input => $regra) {

                //coletar apenas as regras aplicáveis aos parâmetros parciais da requisição PATCH
                if(array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }

            $request->validate($regrasDinamicas,  $produto->feedback());

        } else {
            $request->validate($produto->rules(), $produto->feedback());
        }

        $produto->update([

            'status' => $request->status,
            'imported_t' => $request->imported_t,
            'product_name' => $request->product_name,
            'quantity' => $request->quantity,
            'categories' => $request->categories,
            'cities' => $request->cities

        ]);

        return response()->json($produto, 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produto = $this->produtos->find($id);
        if ($produto === null) {
            return response()->json(['erro' => 'Impossivel realizar exclusão. O recurso solicitado não existe'], 200); // json
        }


        $produto->delete();
        return ['msg' => 'Registro removido com sucesso!'];
    }
}
