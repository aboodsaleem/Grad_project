<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role'     => 'required|in:customer,service_provider',
        ]);

        $user = User::create([
            'username' => $request->username,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'status'   => 'inactive',
            'role'     => $request->input('role', 'customer'),
        ]);

        // إشعار الإدمن بوجود مستخدم جديد
        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new \App\Notifications\Admin\GenericAdminNotification(
                title: 'مستخدم جديد',
                message: "تم تسجيل {$user->username} كـ {$user->role}"
            ));
        }

        event(new Registered($user));

        $notification = [
            'message'    => 'log in success',
            'alert-type' => 'success'
        ];

        Auth::login($user);

        if ($user->role === 'customer') {
            return redirect()->route('customer.dashboard')->with($notification);
        } elseif ($user->role === 'service_provider') {
            return redirect()->route('provider.dashboard')->with($notification);
        }
    }
}
