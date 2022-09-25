<?php

namespace App\Presenters\v1;

use App\Presenters\BasePresenter;

class UserPresenter extends BasePresenter
{
    public function info()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
        ];
    }
}
