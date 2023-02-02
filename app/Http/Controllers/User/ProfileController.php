<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LocationController;
use App\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;
use App\Models\Profile;

class ProfileController extends Controller
{
    protected $socialsController;
    protected $locationsController;

    public function __construct(SocialsController $socialsController, LocationController $locationsController)
    {
        $this->socialsController = $socialsController;
        $this->locationsController = $locationsController;
    }

    public function index($id = null)
    {
        if ($id) {
            $data = Profile::where('id', $id)->first();
        } else {
            $data = Profile::all();
        }
        return [
            'data' => $data
        ];
    }

    public function create(Request $request)
    {
        $profile = Profile::create($request->user_id);
        if ($profile) {
            return response(['message' => 'Profile created successfully.'], 200);
        } else {
            return response(['message' => 'Profile could not be created.'], 422);
        }
    }

    public function update($id, Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'nullable',
            'facebook' => 'nullable',
            'instagram' => 'nullable',
            'twitter' => 'nullable',
            'location' => 'nullable',
            'picture' => 'nullable',
            'prof_status' => 'nullable',
            'information' => 'nullable',
            'mobile' => 'nullable',
        ]);

        if (!$validated['instagram'] || !$validated['facebook'] || !$validated['twitter']) {
            $validated['socials_id'] = $this->updateSocials($validated);
        }

        if ($validated['location']) {
            $validated['locations_id'] = $this->updateLocation($validated['location']);
        }

        $profile = Profile::updateOrCreate(['id' => $id], $validated);
        if ($profile) {
            return response(['message' => 'Profile updated successfully.'], 200);
        } else {
            return response(['message' => 'Profile could not be updated.'], 422);
        }
    }

    private function updateLocation($location)
    {
        $loc_id = $this->locationsController->index($location)->id;
        // if (!$loc) {
        //     $loc_id = null;
        // } else {
        //     $loc_id = $loc->id;
        // }
        return $this->locationsController->create($loc_id, $location)->id;
    }

    private function updateSocials($validated)
    {
        $socials_params = [
            'instagram' => $validated['instagram'],
            'facebook' => $validated['facebook'],
            'twitter' => $validated['twitter'],
        ];
        $soc = $this->socialsController->index($socials_params);
        if (!$soc) {
            $soc_id = null;
        } else {
            $soc_id = $soc->id;
        }
        return $this->socialsController->create($soc_id, $socials_params)->id;
    }
}
