<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\Models\RealStatePhoto;
use Illuminate\Http\Request;

class RealStatePhotoController extends Controller
{

    private $realStatePhoto;

    public function __construct(RealStatePhoto $realStatePhoto) {
        $this->realStatePhoto = $realStatePhoto;
    }

    public function setThumb(string $photoId, string $realStateId) {
        try {
            $photo = $this->realStatePhoto->where('is_thumb', true)->where('real_state_id', $realStateId)->first();

            if ($photo->count()) $photo->update(['is_thumb' => false]);

            $photo = $this->realStatePhoto->find($photoId);
            $photo->update(['is_thumb' => true]);

        } catch (\Exception $exception) {
            $message = new ApiMessages($exception->getMessage());
            return response()->json(['Error' => $message->getMessage()]);
        }
    }

    public function removePhoto($photoId) {

    }
}
