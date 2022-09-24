<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\User\UpdateTokenRequest;
use App\Http\Requests\User\UpdateUserRequest;
use Illuminate\Http\Request;
use App\Services\v1\UserService;

class UserController extends ApiController
{
    private UserService $service;

    public function __construct() {
        $this->service = new UserService;
    }

    public function info($id)
    {
        return $this->result($this->service->info($id));
    }

    public function update(UpdateUserRequest $request)
    {
        $data = $request->validated();
        return $this->result($this->service->update($data));
    }

    public function offersList()
    {
        return $this->result($this->service->offersList());
    }

    public function verifyEmail(Request $request)
    {
        return $this->result($this->service->verifyEmail($request->user()));
    }

    public function resendVerify(Request $request)
    {
        return $this->result($this->service->resendVerify($request->user()));
    }
}
