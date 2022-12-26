<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\FileRequest;
use App\Models\File;
use App\Models\Folder;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FileController extends Controller
{
    protected $service;

    public function __construct(FileService $service){
        $this->service = $service;
    }

    public function upload(FileRequest $request, Folder $folder): ?\Illuminate\Http\JsonResponse
    {
        return $this->service->upload($request, $folder);
    }

    public function delete(File $file): \Illuminate\Http\JsonResponse
    {
        $this->service->delete($file);
        return response()->json([
               "success" => $file,
           ]);
    }

    public function sendFile(File $file): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return $this->service->sendFile($file);
    }

    public function diskSize(): \Illuminate\Http\JsonResponse
    {
        return $this->service->diskSize();
    }
}
