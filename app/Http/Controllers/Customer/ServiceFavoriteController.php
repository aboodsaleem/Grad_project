<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceFavoriteController extends Controller
{
     public function AddToFavorite(Request $request, $service_id){

        if (Auth::check()) {
            $exists = Favorite::where('customer_id',Auth::id())->where('service_id',$service_id)->first();

            if (!$exists) {
               Favorite::insert([
                'customer_id' => Auth::id(),
                'service_id' => $service_id,
                'created_at' => Carbon::now(),

               ]);
               return response()->json(['success' => 'Successfully Added On Your Wishlist' ]);
            } else{
                return response()->json(['error' => 'This Product Has Already on Your Wishlist' ]);

            }

        }else{
            return response()->json(['error' => 'At First Login Your Account' ]);
        }

    }
    // End Method

     public function Getfavoritelistservice(){

        $FavoriteList = Favorite::with('service')->where('customer_id',Auth::id())->latest()->get();

        $FavoriteQty = Favorite::count();

        return response()->json(['FavoriteList'=> $FavoriteList, 'FavoriteQty' => $FavoriteQty]);

    }// End Method

    public function RemoveFromFavorite(Request $request, $service_id)
{
    if (Auth::check()) {
        $favorite = Favorite::where('customer_id', Auth::id())
                            ->where('service_id', $service_id)
                            ->first();

        if ($favorite) {
            $favorite->delete();

            return response()->json(['success' => 'Successfully removed from your favorites.']);
        } else {
            return response()->json(['error' => 'This service is not in your favorites.']);
        }
    } else {
        return response()->json(['error' => 'Please login first.']);
    }
}

}
