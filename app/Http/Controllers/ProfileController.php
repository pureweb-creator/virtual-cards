<?php

namespace App\Http\Controllers;

use App\DTO\LocationDTO;
use App\DTO\SocialLinkDTO;
use App\DTO\UserAvatarDTO;
use App\DTO\UserProfileDTO;
use App\Http\Requests\StoreUserLocationRequest;
use App\Http\Requests\StoreUserAvatarRequest;
use App\Http\Requests\StoreUserInfoRequest;
use App\Http\Requests\StoreUserSocialLinksRequest;
use App\Jobs\GenerateVcard;
use App\Models\SocialNetwork;
use App\Models\User;
use App\Services\ProfileService;
use chillerlan\QRCode\QRCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function __construct(
        private readonly ProfileService $profileService
    ) {}

    public function index()
    {
        $userPage = route('user.page', Auth::user()->user_hash);

        return view('pages.profile.dashboard', [
            'user' => Auth::user()->load(['socialNetworks', 'locations']),
            'qr' => (new QRCode())->render($userPage),
            'uniqueLink' => $userPage,
            'socialNetworks' => SocialNetwork::all(),
        ]);
    }

    public function update(StoreUserInfoRequest $request)
    {
        $userProfileDTO = new UserProfileDTO(
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

        $this->profileService->updateUserLocation($userAddressDTO);

        return back()->with([
            'messageAddress'=>'Info updated successfully',
        ]);

    }

    public function	storeAvatar(StoreUserAvatarRequest $request)
    {
        $this->profileService->storeAvatar(
            new UserAvatarDTO($request->image)
        );

        return response()->json([
            'success'=>'true'
        ]);
    }

    public function destroyAvatar()
    {
        $this->profileService->destroyAvatar();

        return back()->with([
            'messageAvatar'=>'Profile picture deleted successfully',
        ]);
    }

    public function generateCard(ProfileService $profileService)
    {
        $profileService->generateVcard(
            Auth::user()->load(['socialNetworks', 'locations'])
        );

        return back()->with([
            'messageCard'=>'Card updated successfully',
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

    public function page($hash)
    {
        $user = User::where('user_hash', $hash)
            ->with(['socialNetworks', 'locations'])
            ->firstOrFail();

        return view('pages.profile.page', [
            'hash'=>$hash,
            'user'=> $user
        ]);
    }

    public function downloadVcard(string $hash)
    {
        $file = Storage::disk('s3')->get($hash.'.vcf');

        $headers = [
            'Content-Type' => 'text/vcf',
            'Content-Disposition' => "attachment; filename={$hash}.vcf",
            'filename'=> $hash.'.vcf'
        ];

        return response($file, 200, $headers);
    }
}
