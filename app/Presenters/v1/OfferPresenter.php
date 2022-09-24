<?php

namespace App\Presenters\v1;

use App\Presenters\BasePresenter;

class OfferPresenter extends BasePresenter
{
    public function index()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'user_id' => (new UserPresenter($this->user))->shortInfo,
            'image_path' => $this->image_path,
        ];
    }

    public function info()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'user_id' => (new UserPresenter($this->user))->shortInfo,
            'status' => $this->getStatus(),
            'image_path' => $this->image_path,
            'rate' => $this->rate ? $this->rate : null,
        ];
    }
}
