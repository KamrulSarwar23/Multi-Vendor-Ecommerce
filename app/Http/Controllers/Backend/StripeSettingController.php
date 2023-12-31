<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\StripeSetting;
use Illuminate\Http\Request;

class StripeSettingController extends Controller
{
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => ['required', 'integer'],
            'mode' => ['required', 'integer'],
            'country' => ['required', 'max:200'],
            'currency' => ['required', 'max:200'],
            'currency_rate' => ['required'],
            'client_id' => ['required'],
            'secret_key' => ['required'],
        ]);

        StripeSetting::UpdateOrCreate(

            ['id' => $id],
            
            [
                'status' => $request->status,
                'mode' => $request->mode,
                'country' => $request->country,
                'currency' => $request->currency,
                'currency_rate' => $request->currency_rate,
                'client_id' => $request->client_id,
                'secret_key' => $request->secret_key,
            ]
        );

        toastr('Updated Stripe Setting Successfully');
        return redirect()->back();
    }
}
