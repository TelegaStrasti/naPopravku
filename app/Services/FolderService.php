<?php

namespace App\Services;

use App\Models\Folder;
use Illuminate\Support\Facades\Auth;

class FolderService
{
    public function index(){
        return  Folder::all()->where('user_id', '=', Auth::id());
    }

    public function create($request){
        return Folder::create(
            [
                'name' => $request->name,
                'user_id' => Auth::id(),
            ]
        );
    }

    public function show($id){
        $folder = Folder::find($id);
        if (is_null($folder)) {
            return $this->sendError('Папки нет.');
        }
    }
}
