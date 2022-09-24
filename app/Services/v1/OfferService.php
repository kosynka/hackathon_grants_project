<?php

namespace App\Services\v1;

use App\Models\Offer;
use App\Models\User;
use App\Repositories\OfferRepository;
use App\Repositories\ReportRepository;
use App\Repositories\OrderRepository;
use App\Presenters\v1\OfferPresenter;
use App\Services\BaseService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class OfferService extends BaseService
{
    private OfferRepository $offerRepository;

    public function __construct()
    {
        $this->offerRepository = new OfferRepository();
    }

    public function create(array $data)
    {
        $user = auth('api')->user();

        if (!$user) {
            return $this->errNotFound('Исполнитель не найден');
        }

        $data['status'] = Offer::STATUS_CREATED;
        $data['user_id'] = $user->id;

        $image = $data['document_path'];
        $fileName = time() . $image->getClientOriginalName();
        Storage::disk('public')->put('offer/document/' . $fileName, File::get($image));
        $data['document_path'] = 'storage/offer/document/' . $fileName;

        if (isset($data['image_path'])) {
            $image = $data['image_path'];
            $fileName = time() . $image->getClientOriginalName();
            Storage::disk('public')->put('offer/image/' . $fileName, File::get($image));
            $data['image_path'] = 'storage/offer/image/' . $fileName;
        }

        $this->offerRepository->create($data);

        return $this->ok('Предложение создано');
    }

    public function index()
    {
        $offers = $this->offerRepository->index();
        
        return $this->resultCollections($offers, OfferPresenter::class, 'index');
    }

    public function info($id)
    {
        $offer = $this->offerRepository->info($id);
        
        return $this->result(['offer' => (new OfferPresenter($offer))->info()]);
    }
}
