<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\KasBesar;
use App\Models\Divisi;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\KasBesar as KBResource;
use App\Http\Resources\Divisi as DivisiResource;
use Illuminate\Http\Request;

class DividenController extends BaseController
{

    public function divisi(Request $request): JsonResponse
    {
        $divisi = Divisi::where('url', $request->url)->first();

        if (is_null($divisi)) {
            return $this->sendError('Product not found.');
        }

        return $this->sendResponse(new DivisiResource($divisi), 'Divisi retrieved successfully.');
    }

    public function index(): JsonResponse
    {
        $kasBesar = Divisi::get();
        return $this->sendResponse(KBResource::collection($kasBesar), 'Kas Besar retrieved successfully.');
    }
}
