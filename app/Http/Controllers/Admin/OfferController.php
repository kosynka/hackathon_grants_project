<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use App\Models\Offer;
use App\Models\Admin;
use App\Models\Rate;

class OfferController extends Controller
{
    public function index()
    {
        $offers = Offer::where('status', Offer::STATUS_CREATED)->with(['user'])->paginate(50);

        $admin = auth('api')->user();
        
        if ($admin->role == Admin::ROLE_ADMIN) {
            return view('admin.offer', compact('offers'));
        } else {
            return view('jury.offer', compact('offers'));
        }
    }

    public function oldIndex()
    {
        $offers = Offer::whereNot('status', Offer::STATUS_CREATED)->with(['user'])->paginate(50);

        return view('admin.old_offer', compact('offers'));
    }

    public function details($id)
    {
        $offer = Offer::find($id);

        $jury = auth('api')->user();

        if ($jury->role == Admin::ROLE_ADMIN) {
            return view('admin.offer', compact('offers'));
        } else {
            $rate = Rate::where([['admin_id', $jury->id], ['offer_id', $offer->id]])->first();
            return view('admin.jury_offer_details', compact('offer', 'jury', 'rate'));
        }
    }

    public function download($url)
    {
        return Response::download('url($url)');
    }

    private function encodeJsonImages($images)
    {
        if (isset($images)) {
            return json_decode($images);
        } else {
            return null;
        }
    }
}