<?php

namespace App\Http\Controllers;

use App\DTO\LocationDTO;
use App\DTO\SocialLinkDTO;
use App\DTO\UserAvatarDTO;
use App\DTO\UserProfileUpdateDTO;
use App\Http\Requests\StoreUserLocationRequest;
use App\Http\Requests\StoreUserAvatarRequest;
use App\Http\Requests\StoreUserInfoRequest;
use App\Http\Requests\StoreUserSocialLinksRequest;
use App\Models\SocialNetwork;
use App\Services\AvatarService;
use App\Services\ProfileService;
use chillerlan\QRCode\QRCode;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct(
        private readonly ProfileService $profileService
    ) {}

    public function index()
    {
        $userPage = route('user.page', Auth::user()->user_hash);

        return view('pages.profile.dashboard', [
            'user' => Auth::user()->load(['socialNetworks', 'location']),
            'qr' => (new QRCode())->render($userPage),
            'uniqueLink' => $userPage,
            'socialNetworks' => SocialNetwork::all(),
        ]);
    }

    public function update(StoreUserInfoRequest $request)
    {
        $data = $request->validated();
        $userProfileDTO = new UserProfileUpdateDTO(
            first_name: $data['first_name'],
            last_name: $data['last_name'] ?? null,
            home_tel: $data['home_tel'] ?? null,
            work_tel: $data['work_tel'] ?? null,
            website: $data['website'] ?? null,
            company: $data['company'] ?? null,
            job_title: $data['job_title'] ?? null,
        );

        $this->profileService->update($userProfileDTO);

        return back()->with([
            'message'=>'Info updated successfully',
        ]);
    }

    public function updateUserAddress(StoreUserLocationRequest $request)
    {
        $data = $request->validated();
        $userAddressDTO = new LocationDTO(
            country: $data['country'] ?? null,
            city: $data['city'] ?? null,
            street: $data['street'] ?? null,
            postcode: $data['postcode'] ?? null,
        );

        $this->profileService->updateUserAddress($userAddressDTO);

        return back()->with([
            'messageAddress'=>'Info updated successfully',
        ]);
    }

    public function updateUserSocialLinks(StoreUserSocialLinksRequest $request)
    {
        $data = $request->validated();
        $dto = new SocialLinkDTO(
            telegram: $data['telegram'] ?? null,
            facebook: $data['facebook'] ?? null,
            instagram: $data['instagram'] ?? null,
            whatsapp: $data['whatsapp'] ?? null,
            twitter: $data['twitter'] ?? null,
            telegram_hidden: isset($data['telegram_hidden']) ? (bool) $data['telegram_hidden'] : null,
            facebook_hidden: isset($data['facebook_hidden']) ? (bool) $data['facebook_hidden'] : null,
            instagram_hidden: isset($data['instagram_hidden']) ? (bool) $data['instagram_hidden'] : null,
            whatsapp_hidden: isset($data['whatsapp_hidden']) ? (bool) $data['whatsapp_hidden'] : null,
            twitter_hidden: isset($data['twitter_hidden']) ? (bool) $data['twitter_hidden'] : null,
        );
        $this->profileService->updateUserSocialLinks($dto);

        return back()->with([
            'messageSocLink'=>'Info updated successfully',
        ]);
    }

    public function	storeAvatar(StoreUserAvatarRequest $request, AvatarService $avatarService)
    {
        $avatarService->store(
            new UserAvatarDTO($request->image)
        );

        return response()->json([
            'success'=>'true'
        ]);
    }

    public function destroyAvatar(AvatarService $avatarService)
    {
        $avatarService->destroy();

        return back()->with([
            'messageAvatar'=>'Profile picture deleted successfully',
        ]);
    }

    public function getUserPage(string $hash)
    {
        return view('pages.profile.page', [
            'hash'=> $hash,
            'user'=> $this->profileService->getUserProfile($hash)
        ]);
    }
}
