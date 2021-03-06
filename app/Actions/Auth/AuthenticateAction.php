<?php

namespace App\Actions\Auth;

use App\Actions\AbstractAction;
use App\Enums\Responses\ErrorEnum;
use App\Exceptions\ApiErrorException;
use App\Models\User\User;
use Illuminate\Support\Facades\Hash;

class AuthenticateAction extends AbstractAction
{
    /**
     * @param array $requestData
     * @return string
     * @throws ApiErrorException
     */
    public function handle(array $requestData): string
    {
        $requestData = collect($requestData);
        $email = $requestData->get('email');
        $password = $requestData->get('password');

        $user = User::where('email', $email)->first();

        if (! $user || ! Hash::check($password, $user->password)) {
            throw  new ApiErrorException(
                'wrong_data',
                ErrorEnum::WRONG_DATA,
                'Неверный логин или пароль',
                422,
                []
            );
        }

        $user->tokens()->delete();

        return $user->createToken('access_token')->plainTextToken;

    }

}
