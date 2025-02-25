<?php

namespace App\Services;

use App\DTO\VCardDTO;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use JeroenDesloovere\VCard\VCard;
use Symfony\Component\HttpFoundation\StreamedResponse;

class VCardService
{
    public function generate(VCardDTO $dto): string
    {
        $user = User::find($dto->userId)->load(['socialNetworks', 'location']);

        $userLocation = $user->location;
        $lastname = $user->last_name;
        $firstname = $user->first_name;
        $additional = '';
        $prefix = '';
        $suffix = '';

        $vcard = new VCard();
        $vcard->addName($lastname, $firstname, $additional, $prefix, $suffix);

        $vcard->addCompany($user->company);
        $vcard->addJobtitle($user->job_title);
        $vcard->addEmail($user->email);
        $vcard->addPhoneNumber($user->home_tel, 'PREF;WORK');
        $vcard->addPhoneNumber($user->work_tel, 'WORK');
        $vcard->addAddress(null, null, $userLocation->street, $userLocation->city, null, $userLocation->postcode, $userLocation->country);
        $vcard->addURL($user->website);

        foreach ($user->socialNetworks as $socialNetwork) {
            if (!is_null($socialNetwork->pivot->link) && !$socialNetwork->pivot->hidden) {
                $vcard->addURL($socialNetwork->url_pattern.''.$socialNetwork->pivot->link);
            }
        }

        if (!is_null($user->avatar)) {
            $vcard->addPhotoContent(Storage::get($user->avatar));
        }

        return Storage::put($user->user_hash.'.vcf', $vcard->getOutput(), 'public');
    }

    public function download(string $hash): StreamedResponse
    {
        $user = User::where('user_hash', $hash)->first();
        return Storage::download($hash.'.vcf', $user->first_name.'-'.$user->last_name.'.vcf');
    }
}
