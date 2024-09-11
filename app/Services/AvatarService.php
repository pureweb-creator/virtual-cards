<?php

namespace App\Services;

use App\DTO\UserAvatarDTO;
use App\Jobs\GenerateVcard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AvatarService
{
    public function store(UserAvatarDTO $dto): void
    {
        $image = $dto->base64ImgString;

        list(, $image) = explode(';', $image);
        list(, $image) = explode(',', $image);
        $image_content = base64_decode($image);
        $image_name = Str::random(40).'.png';

        $user = Auth::user();

        if (!is_null($user->avatar)){
            Storage::delete($user->avatar);
        }

        Storage::put($image_name, $image_content, 'public');

        $user->avatar = $image_name;
        $user->save();

        GenerateVcard::dispatch(
            Auth::id()
        );

        Cache::forget('user');
    }
    public function destroy(): void
    {
        $user = Auth::user();
        Storage::delete($user->avatar);
        $user->avatar = null;
        $user->save();

        GenerateVcard::dispatch(
            Auth::id()
        );

        Cache::forget('user');
    }
}
