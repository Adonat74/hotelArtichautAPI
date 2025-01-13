<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Mail\Mailables\Content;

class contentController extends Controller
{
    public function getAllContent() {
        return response()->json([
            'contents'=> 'content list',
        ]);
    }

    public function getSingleContent(String $id) {
        return response()->json([
            'content'=>'single content',
        ]);
    }

    public function addContent(Request $request) {
        return response()->json([
            'content'=>'content added',
        ]);
    }

    public function updateContent(Request $request, String $id) {
        return response()->json([
            'content'=>'content '. $id.' updated',
        ]);
    }

    public function deleteContent(String $id) {
        return response()->json([
            'content'=>'content '. $id.' deleted',
        ]);
    }
}
