<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{

    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $users = $this->user->paginate('10');

        return response()->json($users, 200);
    }


    public function store(Request $request)
    {

        $data = $request->all();

        try {

            $user = $this->user->create($data);

            return response()->json(['data' => [
                'msg' => 'criado com sucesso',
                'data' => $user
            ]], 201);

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json(['Error' => $message->getMessage()], 401);
        }
    }


    public function show(string $id)
    {
        try {

            $user = $this->user->findOrFail($id);

            return response()->json(['data' => $user], 200);

        } catch(\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json(['Error' => $message->getMessage()], 401);
        } 
    }

    
    public function update(Request $request, string $id)
    {

        $data = $request->all();

        try {

            $user = $this->user->findOrFail($id);
            $user->update($data);

            return response()->json([
                'data' => [
                    'msg' => 'atualizado',
                    'data' => $user
                ]
            ], 200);

        } catch(\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json(['Error' => $message->getMessage()], 401);
        }
    }


    public function destroy(string $id)
    {
        try {

            $user = $this->user->findOrFail($id);
            $user->delete();

            return response()->json([
                'data' => [
                    'msg' => 'deletado'
                ]
                ], 200);

        } catch(\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json(['Error' => $message->getMessage()], 401);
        }
    }
}