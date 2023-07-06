<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    private $category;


    public function __construct(Category $category)
    {
        $this->category = $category;
    }


    public function index()
    {
        $categories = $this->category->paginate('10');

        return response()->json($categories, 200);
    }


    public function store(CategoryRequest $request)
    {
        $data = $request->all();

        try {

            $category = $this->category->create($data);

            return response()->json(['data' => [
                'msg' => 'criado com sucesso',
                'data' => $category
            ]], 201);

        } catch (\Exception $exception) {
            $message = new ApiMessages($exception->getMessage());
            return response()->json(['Error' => $message->getMessage()], 401);
        }
    }


    public function show(string $id)
    {
        try {

            $category = $this->category->findOrFail($id);

            return response()->json(['data' => $category], 200);

        } catch (\Exception $exception) {
            $message = new ApiMessages($exception->getMessage());
            return response()->json(['Error' => $message->getMessage()], 401);
        }
    }


    public function update(CategoryRequest $request, string $id)
    {
        $data = $request->all();

        try {

            $category = $this->category->findOrFail($id);
            $category->update($data);

            return response()->json(['data' => [
                'msg' => 'atualizado',
                'data' => $category
            ]], 200);

        } catch (\Exception $exception) {
            $message = new ApiMessages($exception->getMessage());
            return response()->json(['Error' => $message->getMessage()], 401);
        }
    }


    public function destroy(string $id)
    {
        try {

            $category = $this->category->findOrFail($id);
            $category->delete();

            return response()->json(['data' => ['msg' => 'deletado']], 200);

        } catch (\Exception $exception) {
            $message = new ApiMessages($exception->getMessage());
            return response()->json(['Error' => $message->getMessage()], 401);
        }
    }
}
