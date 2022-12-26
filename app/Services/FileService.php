<?php

namespace App\Services;

use App\Models\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileService
{
    public function upload($request, $folder)
    {
        if ($file = $request->file('path')) {
            $upload_folder = 'public/files';
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $items = File::all()->where('user_id', '=', Auth::id());
            $size = [];
            foreach ($items as $item) {
                $size[] = Storage::disk('public')->size("files/" . $item->path);
            }
            if (array_sum($size) + $file->getSize() >= 100 * 1024 * 1024) {
                return response()->json([
                    "success" => "хранилище переполнено",
                ]);
            }
            Storage::putFileAs($upload_folder, $file, $filename);
            $save = new File();
            $save->path = $filename;
            $save->folder_id = $folder->id;
            $save->user_id = Auth::id();
            $save->save();

            return response()->json([
                "folder" => $folder->id,
                "success" => true,
                "message" => "Файл загружен"
            ]);
        }
    }

    public function delete($file)
    {
        ($file->delete());
        Storage::disk('public')->delete("/file/" . $file->path);
    }

    public function sendFile($file)
    {
        $path = Storage::disk('public')->path("files/" . $file->path);
        return response()->download($path, basename($path));
    }

    public function diskSize()
    {
        $files = File::all()->where('user_id', '=', Auth::id());
        $size = [];
        foreach ($files as $file) {
            $size[] = Storage::disk('public')->size("files/" . $file->path);
        }

        return response()->json([
            "disk-size" => array_sum($size) . ' байтов на диске',
        ]);
    }

}
