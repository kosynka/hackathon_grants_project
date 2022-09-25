<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\Rate\StoreRateRequest;
use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\Admin;
use App\Models\Rate;

class RateController extends Controller
{
    public function store(StoreRateRequest $request)
    {
        $admin = auth('api')->user();
        $offer = Offer::find($request->id);

        $data['status'] = Offer::STATUS_ON_REVIEW;
        $offer->fill($data);
        $offer->save();

        $data['rate_idea'] = $request->idea;
        $data['rate_realization'] = $request->realization;
        $data['rate_relevance'] = $request->relevance;
        $data['offer_id'] = $offer->id;
        $data['admin_id'] = $admin->id;
        $data['user_id'] = $offer->user->id;

        Rate::create($data);
        
        return redirect()->back();
    }
}
