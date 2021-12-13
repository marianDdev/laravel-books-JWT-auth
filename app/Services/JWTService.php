<?php

namespace App\Services;

use App\Models\Account;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class JWTService
{
    /**
     * @param array   $input
     * @param Account $account
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validateAPIUser(array $input, Account $account)
    {
        $accountsIds = $account->getIds();

        return Validator::make(
            $input,
            [
                'name'       => 'required|string|min:2|max:100',
                'email'      => 'required|string|email|max:100|unique:users',
                'password'   => 'required|string|confirmed|min:6',
                'account_id' => Rule::in($accountsIds),
            ],
            [
                'name.required' => 'Name is required',
                'name.string'   => 'Name must be of type string',
                'name.max'      => 'Name length must not exceed :max characters',
                'name.min'      => 'Name length must be at least :min characters',

                'email.required' => 'Email is required',
                'email.email'    => 'Enter a valid email',
                'email.max'      => 'Email length must not exceed :max characters',
                'email.unique'   => 'This email is already registered',

                'password.required'  => 'Password is required',
                'password.string'    => 'Password must be of type string',
                'password.min'       => 'Password length must be at least :min characters',
                'password.confirmed' => 'Password confirmation is not matching',

                'account_id.in'       => 'Enter a valid account id',
            ]
        );
    }
}
