<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BookingPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Booking $booking)
    {
        // يسمح للعميل برؤية حجزه فقط، أو المدير يراه كله
    return $user->role == 'admin' || $user->id == $booking->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Booking $booking)
    {
        // يسمح للمدير أو مزود الخدمة بتعديل الحالة أو غيرها
    return in_array($user->role, ['admin', 'service_provider']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Booking $booking)
    {
        // فقط المدير يحذف
    return $user->role == 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Booking $booking)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Booking $booking)
    {
        //
    }
}
