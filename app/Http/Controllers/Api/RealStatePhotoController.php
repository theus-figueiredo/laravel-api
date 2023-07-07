<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\Models\RealStatePhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RealStatePhotoController extends Controller
{

    private $realStatePhoto;

    public function __construct(RealStatePhoto $realStatePhoto) {
        $this->realStatePhoto = $realStatePhoto;
    }

    public function setThumb(string $photoId, string $realStateId) {
        try {
            $photo = $this->realStatePhoto->where('is_thumb', true)->where('real_state_id', $realStateId);

            if ($photo->count()) $photo->first()->update(['is_thumb' => false]);

            $photo = $this->realStatePhoto->find($photoId);
            $photo->update(['is_thumb' => true]);

            return response()->json(['data' => ['msg' => 'Thumbnail definida com sucesso']], 200);

        } catch (\Exception $exception) {
            $message = new ApiMessages($exception->getMessage());
            return response()->json(['Error' => $message->getMessage()]);
        }
    }


    public function removePhoto($photoId) {
        try {
            $photo = $this->realStatePhoto->find($photoId);

            if($photo->is_thumb) {
                $message = new ApiMessages('Não é possível remover thumbnail');
                return response()->json(['Error' => $message->getMessage()], 401);
            }

            if ($photo) {
                Storage::disk('public')->delete($photo->photo);
                $photo->delete();
            }

            return response()->json(['data' => ['msg' => 'imagem removida']]);

        } catch (\Exception $exception) {
            $message = new ApiMessages($exception->getMessage());
            return response()->json(['Error' => $message->getMessage()]);
        }
    }
}
