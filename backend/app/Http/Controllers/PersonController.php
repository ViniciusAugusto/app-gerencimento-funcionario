<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Person;
use App\Transformers\PersonTransformer;

class PersonController extends Controller
{
    public function person(Person $person) {

    	$person = $person->all();

    	return fractal()
    	->collection($person)
    	->transformWith(new PersonTransformer)
    	->toArray();

    }

    public function personById(Person $person, $id)
    {
    	$person = $person->find($id);

    	return fractal()
    	->item($person)
    	->transformWith(new PersonTransformer)
        ->includePosts()
    	->toArray();
    }

    public function add(Request $request, Person $person) {
    	
    	$this->validate($request, [
            'nome'  => 'required',
            'sexo'  => 'required',
            'idade' => 'required',
        ]);

    	$person = $person->create([
            'nome'      =>  $request->nome,
            'sexo'      => $request->sexo,
            'idade'     => $request->idade,
            'tipo'      => $request->tipo,
            'linguagem' => $request->linguagem,
            'projeto'   => $request->projeto
        ]);

    	$response = fractal()
    	->item($person)
    	->transformWith(new PersonTransformer)
    	->toArray();

    	return response()->json($response, 201);
    }

    public function update(Request $request, Person $person) {
       // $this->authorize('update', $person);

       $person->nome      = $request->get('nome', $person->nome);
       $person->sexo      = $request->get('sexo', $person->sexo);
       $person->idade     = $request->get('idade', $person->idade);
       $person->tipo      = $request->get('tipo', $person->tipo);
       $person->linguagem = $request->get('linguagem', $person->linguagem);
       $person->projeto   = $request->get('projeto', $person->projeto);
       $person->save();

       return fractal()
       ->item($person)
       ->transformWith(new PersonTransformer)
       ->toArray();
    }

    public function delete(Person $person) {
        //$this->authorize('delete', $person);

        $person->delete();

        return response()->json([
            'message' => 'Pessoa apagada'
            ]);
    }
}
