<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PictureController extends Controller
{
    public function get(Request $request): BinaryFileResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $fileName = public_path('storage/pictures/' . $request->route('filename'));
        return response()->file($fileName);
    }
}
