<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    private $user;

    public function __construct(User $user)
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

        if(!$request->has('password') || !$request->get('password')) {
            $message = new ApiMessages('É preciso informar uma senha pra o usuário');
            return response()->json(['Error' => $message->getMessage()], 401);
        }

        Validator::make($data, [
            'mobile_phone' => 'required'
        ]);

        try {

            $data['password'] = bcrypt($data['password']);

            $user = $this->user->create($data);

            $user->profile()->create([
                'mobile_phone' => $data['mobile_phone']
            ]);

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

        if($request->has('password') && $request->get('password')) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

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
