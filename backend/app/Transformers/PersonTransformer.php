<?php
namespace App\Transformers;

use App\Person;
use League\Fractal\TransformerAbstract;

class PersonTransformer extends TransformerAbstract
{
	public function transform(Person $person)
	{
		return [
			'id' 			=> $person->id,
			'nome' 		    => $person->nome,
            'idade' 	    => $person->idade,
            'created_at'    => $person->created_at,
            'update_at'     => $person->update_at,
            'sexo'          => $person->sexo,
            'tipo'          => $person->tipo,
            'linguagem'     => $person->linguagem,
            'projeto'       => $person->projeto
		];
		
	}
}