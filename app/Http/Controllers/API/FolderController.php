<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\FolderRequest;
use App\Models\File;
use App\Models\Folder;
use App\Services\FolderService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FolderController extends Controller
{
    protected $service;

    /**
     * @return \Illuminate\Http\JsonResponse
     */

    public function __construct(FolderService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json([
            "success" => true,
            "message" => "Список папок текущего пользователя",
            "data" => $this->service->index()
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(FolderRequest $request)
    {
        $folders = $this->service->create($request);
        return response()->json([
            "success" => true,
            "message" => " Создано успешно.",
            "data" => $folders
        ]);
    }

    public function show($id)
    {
        $folder = Folder::find($id);
        $files = File::all()->where('folder_id', '=', $id);
        if (is_null($folder)) {
            return $this->sendError('Папка не найдена');
        }
        return response()->json([
            "success" => true,
            "message" => "Папка найдена",
            "folder" => [
                "folder" => $folder,
                "files" => $files
            ],

        ]);
    }


}
