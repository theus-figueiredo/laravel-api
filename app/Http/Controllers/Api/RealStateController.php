<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\RealStateRequest;
use App\Models\RealState;

class RealStateController extends Controller
{

    private $realState;

    public function __construct(RealState $realState) {
        $this->realState = $realState;
    }


    public function index() {
        $realStates = $this->realState->paginate('10');

        return response()->json($realStates, 200);
    }


    public function show($id) {
        try {

            $realState = $this->realState->with('photos')->findOrFail($id);

            return response()->json(['data' => $realState], 200);

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json(['Error' => $message->getMessage()], 401);
        }
    }


    public function store(RealStateRequest $request) {
        $data = $request->all();
        $images = $request->file('images');
        
        try{

            $realState = $this->realState->create($data);

            if(isset($data['categories']) && count($data['categories'])) {
                $realState->categories()->sync($data['categories']);
            }

            if($images) {

                $uploadedImages = [];

                foreach ($images as $image) {
                    $path = $image->store('images', 'public');
                    $uploadedImages[] = ['photo' => $path, 'is_thumb' => false];
                }

                $realState->photos()->createMany($uploadedImages);
            }

            return response()->json(["data" => [
                'msg' => 'imóvel cadastrado com sucesso',
                'data' => $realState
            ]], 200);

        } catch(\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json(['Error' => $message->getMessage()], 401);
        }
    }


    public function update($id, RealStateRequest $request) {
        $data = $request->all();
        $images = $request->file('images');

        try {

            $realState = $this->realState->findOrFail($id);
            $realState->update($data);

            if(isset($data['categories']) && count($data['categories'])) {
                $realState->categories()->sync($data['categories']);
            }

            if($images) {

                $uploadedImages = [];

                foreach ($images as $image) {
                    $path = $image->store('images', 'public');
                    $uploadedImages[] = ['photo' => $path, 'is_thumb' => false];
                }

                $realState->photos()->createMany($uploadedImages);
            }

            return response()->json([
                'data' => [
                    'msg' => 'imovel atualizado',
                    'data' => $realState
                ]
            ], 200);

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json(['Error' => $message->getMessage()], 401);
        }
    }


    public function destroy($id) {
        try {
            $realState = $this->realState->findOrFail($id);
            $realState->delete();

            return response()->json(['data' => ['msg' => 'deletado com sucesso']], 200);

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json(['Error' => $message->getMessage()], 401);
        }
    }


    public function getUserRealStates() {
        $realStates = auth('api')->user()->real_state()->paginate('10');

        return response()->json(['data' => $realStates], 200);
    }
}
