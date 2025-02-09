<?php

namespace App\Services;

use App\DTO\LocationDTO;
use App\DTO\SocialLinkDTO;
use App\DTO\UserProfileUpdateDTO;
use App\Jobs\GenerateVcard;
use App\Models\Location;
use App\Models\SocialNetwork;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ProfileService
{
    public function update(UserProfileUpdateDTO $dto): void
    {
        Auth::user()->update([
            'first_name'=>$dto->first_name,
            'last_name'=>$dto->last_name,
            'home_tel'=>$dto->home_tel,
            'work_tel'=>$dto->work_tel,
            'website'=>$dto->website,
            'company'=>$dto->company,
            'job_title'=>$dto->job_title
        ]);

        GenerateVcard::dispatch(
            Auth::id()
        );

        Cache::forget('user');
    }

    public function updateUserSocialLinks(SocialLinkDTO $dto): void
    {
        $telegram = SocialNetwork::where('name', 'telegram')->first();
        $twitter = SocialNetwork::where('name', 'twitter')->first();
        $instagram = SocialNetwork::where('name', 'instagram')->first();
        $facebook = SocialNetwork::where('name', 'facebook')->first();
        $whatsapp = SocialNetwork::where('name', 'whatsapp')->first();

        $user = Auth::user();

        $socialLinks = [
            $telegram->id => ['link'=>$dto->telegram, 'hidden'=>(boolean) $dto->telegram_hidden],
            $twitter->id => ['link'=>$dto->twitter, 'hidden'=>(boolean) $dto->twitter_hidden],
            $instagram->id => ['link'=>$dto->instagram, 'hidden'=>(boolean) $dto->instagram_hidden],
            $facebook->id => ['link'=>$dto->facebook, 'hidden'=>(boolean) $dto->facebook_hidden],
            $whatsapp->id => ['link'=>$dto->whatsapp, 'hidden'=>(boolean) $dto->whatsapp_hidden],
        ];

        foreach ($socialLinks as $socialNetworkId=>$attributes) {
            $user->socialNetworks()->syncWithoutDetaching([$socialNetworkId=>$attributes]);
        }

        GenerateVcard::dispatch(
            Auth::id()
        );

        Cache::forget('user');
    }

    public function updateUserAddress(LocationDTO $dto): void
    {
        Location::updateOrCreate(['user_id' => Auth::id()], [
            'country' => $dto->country,
            'city' => $dto->city,
            'street' => $dto->street,
            'postcode' => $dto->postcode,
        ]);

        GenerateVcard::dispatch(
            Auth::id()
        );

        Cache::forget('user');
    }

    public function getUserProfile($hash)
    {
        if (!$user = Cache::get('user')) {

            $user = User::where('user_hash', $hash)
                ->with(['socialNetworks', 'location'])
                ->firstOrFail();

            Cache::put('user', $user);
        }

        return $user;
    }
}
