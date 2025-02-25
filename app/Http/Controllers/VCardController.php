<?php

namespace App\Http\Controllers;

use App\DTO\VCardDTO;
use App\Services\VCardService;
use Illuminate\Support\Facades\Auth;

class VCardController extends Controller
{
    public function generate(VCardService $VCardService)
    {
        $VCardService->generate(
            new VCardDTO(userId: Auth::id())
        );

        return back()->with([
            'messageCard'=>'Card updated successfully',
        ]);
    }

    public function download(string $hash, VCardService $VCardService)
    {
        return $VCardService->download($hash);
    }
}
