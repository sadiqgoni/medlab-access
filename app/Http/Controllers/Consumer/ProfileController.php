<?php

namespace App\Http\Controllers\Consumer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Consumer\UpdateProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('consumer.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        // Update only the fillable fields provided in the validated data
        $user->fill($request->validated());

        // Handle communication preferences separately if needed (example)
        $user->communication_preferences = $request->input('communication_preference', []);

        // Note: Email verification is not handled here if email were changeable.
        
        $user->save();

        return redirect()->route('consumer.profile.edit')->with('status', 'profile-updated');
    }

    // We can add methods for password update and account deletion later.
}
