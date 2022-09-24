<?php

namespace App\Repositories;

use App\Models\Offer;

class OfferRepository
{
    public function create(array $data) : void
    {
        Offer::create($data);
    }

    public function update(Offer $offer, array $data) : void
    {
        $offer->update($data);
    }

    public function info(int $id)
    {
        return Offer::find($id);
    }

    public function index()
    {
        return Offer::all();
    }

    public function getCreated(int $orderId)
    {
        return Offer::where('order_id', $orderId)
            ->where('status', Offer::STATUS_CREATED)
            ->get();
    }
}
