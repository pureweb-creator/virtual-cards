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
        $userProfileDTO = new UserProfileUpdateDTO(
            ...$request->validated(),
        );

        $this->profileService->update($userProfileDTO);

        return back()->with([
            'message'=>'Info updated successfully',
        ]);
    }

    public function updateUserAddress(StoreUserLocationRequest $request)
    {
        $userAddressDTO = new LocationDTO(
            ...$request->validated()
        );

        $this->profileService->updateUserAddress($userAddressDTO);

        return back()->with([
            'messageAddress'=>'Info updated successfully',
        ]);
    }

    public function updateUserSocialLinks(StoreUserSocialLinksRequest $request)
    {
        $dto = new SocialLinkDTO(...$request->validated());
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
