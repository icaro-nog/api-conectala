<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(!auth()->user()->tokenCan('user-index')){
            return $this->error('Unauthorized', 403);
        }
        return User::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return $this->error('Dados inválidos', 422, $validator->errors());
        }

        $created = User::create($validator->validated());

        if($created){
           return $this->response('Usuário cadastrado com sucesso!', 200, [$created]);
        }

        return $this->error('Erro ao tentar cadastrar usuário', 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(!auth()->user()->tokenCan('user-show')){
            return $this->error('Unauthorized', 403);
        }

        $user = User::where('id', $id)->first();

        if($user){
            return $this->response('Sucesso!', 200, [$user]);
        }

        return $this->response('Usuário inexistente!', 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        if(!auth()->user()->tokenCan('user-update')){
            return $this->error('Unauthorized', 403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return $this->error('Dados inválidos', 422, $validator->errors());
        }

        $updated = User::where('id', $id)->update($validator->validated());

        if($updated){
           return $this->response('Usuário atualizado com sucesso!', 200, [User::where('id', $id)->first()]);
        }

        return $this->error('Erro ao tentar atualizar usuário', 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        if(!auth()->user()->tokenCan('user-destroy')){
            return $this->error('Unauthorized', 403);
        }

        $destroyed = User::where('id', $id)->delete();

        if($destroyed){
            return $this->response('Usuário deletado com sucesso!', 200);
        }

        return $this->error('Erro ao tentar deletar usuário', 400);
    }
}
