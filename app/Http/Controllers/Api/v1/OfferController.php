<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Offer\CreateOfferRequest;
use App\Services\v1\OfferService;

class OfferController extends ApiController
{
    private OfferService $offerService;
    
    public function __construct()
    {
        $this->offerService = new OfferService();
    }

    public function index()
    {
        return $this->result($this->offerService->index());
    }

    public function info($id)
    {
        return $this->result($this->offerService->info($id));
    }

    public function create(CreateOfferRequest $request)
    {
        $data = $request->validated();
        
        return $this->result($this->offerService->create($data));
    }
}
