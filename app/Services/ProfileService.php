<?php

namespace App\Services;

use App\DTO\LocationDTO;
use App\DTO\SocialLinkDTO;
use App\DTO\UserAvatarDTO;
use App\DTO\UserProfileDTO;
use App\Models\Locations;
use App\Models\SocialNetwork;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use JeroenDesloovere\VCard\VCard;

class ProfileService
{
    public function update(UserProfileDTO $dto): void
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
    }

    public function storeAvatar(UserAvatarDTO $dto): void
    {
        $image = $dto->base64ImgString;

        list(, $image) = explode(';', $image);
        list(, $image) = explode(',', $image);
        $image = base64_decode($image);
        $image_name = Str::random(40).'.png';

        $user = Auth::user();

        if (!is_null($user->avatar)){
            $avatarFileName = explode(config('filesystems.disks.s3.url'), $user->avatar)[1];

            Storage::disk('s3')->delete($avatarFileName);
        }

        Storage::disk('s3')->put($image_name, $image, 'public');

        $user->avatar = Storage::disk('s3')->url($image_name);
        $user->save();
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
    }

    public function updateUserLocation(LocationDTO $dto): void
    {
        Locations::updateOrCreate(['user_id' => Auth::id()], [
            'country' => $dto->country,
            'city' => $dto->city,
            'street' => $dto->street,
            'postcode' => $dto->postcode,
        ]);
    }

    public function generateVcard(): string
    {
        $vcard = new VCard();
        $user = Auth::user()->load(['socialNetworks', 'locations']);
        $userLocation = $user->locations->first();

        $lastname = $user->last_name;
        $firstname = $user->first_name;
        $additional = '';
        $prefix = '';
        $suffix = '';

        $vcard->addName($lastname, $firstname, $additional, $prefix, $suffix);

        $vcard->addCompany($user->company);
        $vcard->addJobtitle($user->job_title);
        $vcard->addEmail($user->email);
        $vcard->addPhoneNumber($user->home_tel, 'PREF;WORK');
        $vcard->addPhoneNumber($user->work_tel, 'WORK');

        if (!is_null($userLocation)){
            $vcard->addAddress(null, null, $userLocation->street, $userLocation->city, null, $userLocation->postcode, $userLocation->country);
        }

        $vcard->addURL($user->website);

        foreach ($user->socialNetworks as $socialNetwork) {
            if (!is_null($socialNetwork->pivot->link) && !$socialNetwork->pivot->hidden) {
                $vcard->addURL($socialNetwork->url_pattern.''.$socialNetwork->pivot->link);
            }
        }

        if (!is_null($user->avatar)) {
            $vcard->addPhoto(Auth::user()->avatar);
        }

        return Storage::disk('s3')->put($user->user_hash.'.vcf', $vcard->getOutput(), 'public');
    }

    public function destroyAvatar(): void
    {
        $user = Auth::user();
        $avatarFileName = explode(config('filesystems.disks.s3.url'), $user->avatar)[1];
        Storage::disk('s3')->delete($avatarFileName);
        $user->avatar = null;
        $user->save();
    }
}
