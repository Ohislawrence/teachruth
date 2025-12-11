<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SchoolProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SchoolRegistrationController extends Controller
{
    // Step 1: Basic Information
    public function showStep1()
    {
        return Inertia::render('School/Register/Step1', [
            'title' => 'School Registration - Step 1'
        ]);
    }

    public function storeStep1(Request $request)
{
    try {
        \Log::info('Registration attempt', $request->all());

        $validated = $request->validate([
            'school_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'email.unique' => 'This email is already registered. Please use a different email.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Passwords do not match.',
        ]);

        \Log::info('Validation passed', $validated);

        // Create user account
        $user = User::create([
            'name' => $validated['school_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'type' => User::TYPE_SCHOOL,
        ]);

        \Log::info('User created', ['user_id' => $user->id]);

        // Create school profile with basic info
        $user->schoolProfile()->create([
            'school_name' => $validated['school_name'],
            'phone' => $validated['phone'],
            'address' => 'pending',
            'state' => 'pending',
            'lga' => 'pending',
            'website'  => 'pending',
            'logo_path'  => 'pending',
            'school_type' => 'mixed',
            'ownership' => 'private',
            'is_verified' => 0,
            ]);

        \Log::info('School profile created');

        // Log in the user
        Auth::login($user);

        \Log::info('User logged in');

        return redirect()->route('school.register.step2');

    } catch (\Illuminate\Validation\ValidationException $e) {
        \Log::error('Validation failed', ['errors' => $e->errors()]);

        // Return with validation errors
        return redirect()->route('school.register.step1')
            ->withErrors($e->validator)
            ->withInput();
    } catch (\Exception $e) {
        \Log::error('Registration error', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        // Return with general error
        return redirect()->route('school.register.step1')
            ->with('error', 'An error occurred during registration. Please try again.');
    }
}

    // Step 2: School Details
    public function showStep2()
    {
        return Inertia::render('School/Register/Step2', [
            'title' => 'School Registration - Step 2'
        ]);
    }

    public function storeStep2(Request $request)
    {
        $validated = $request->validate([
            'about' => 'nullable|string|max:1000',
            'address' => 'required|string|max:500',
            'state' => 'required|string|max:100',
            'lga' => 'required|string|max:100',
            'website' => 'nullable|url|max:255',
            'school_type' => 'required|in:nursery,primary,secondary,mixed',
            'ownership' => 'required|in:private,public,mission,community',
        ]);

        $user = Auth::user();

        // Update school profile
        $user->schoolProfile()->update($validated);

        return redirect()->route('school.register.step3');
    }

    // Step 3: Verification (Optional)
    public function showStep3()
    {
        return Inertia::render('School/Register/Step3', [
            'title' => 'School Registration - Step 3'
        ]);
    }

    public function completeRegistration(Request $request)
    {
        $user = Auth::user();

        // Mark registration as complete (optional - you can add a field to track this)
        $user->update([
            'registration_completed_at' => now(),
        ]);

        // Welcome message
        $request->session()->flash('success', 'Registration completed successfully! Welcome to our platform.');

        return redirect()->route('school.dashboard');
    }
}
