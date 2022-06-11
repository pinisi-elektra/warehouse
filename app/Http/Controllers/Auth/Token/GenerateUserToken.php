<?php

namespace App\Http\Controllers\Auth\Token;

use App\Http\Requests\Auth\LoginRequest;

class GenerateUserToken
{
    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function __invoke(LoginRequest $request) {
        $request->authenticate();

        $token = $request->user()->createToken('user');

        return ['token' => $token->plainTextToken];
    }
}
