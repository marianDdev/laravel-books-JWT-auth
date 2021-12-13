<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class BooksService
{
    /**
     * @param array $input
     *
     * @return array
     * @throws ValidationException
     */
    public function validateInput(array $input): array
    {
            $validator = Validator::make(
                $input,
                [
                    'title'       => ['required', 'string', 'max:255'],
                    'author'      => ['required', 'string', 'min:2', 'max:255', 'unique:books,author,NULL,id,title,'.$input['title']],
                    'released_at' => ['required', 'date'],
                ],
                [
                    'title.required' => 'Title is required',
                    'title.string'   => 'Title must be of type string',
                    'title.max'      => 'Title length must not exceed :max characters',

                    'author.required' => 'Author is required',
                    'author.string'   => 'Author must be of type string',
                    'author.min'      => 'Author length must be at least :min',
                    'author.max'      => 'Author length must be at least :max',
                    'author.unique'   => 'This book is already added to this account',

                    'released_at.required' => 'Release Date is required',
                    'released_at.date'     => 'Release Date must be a valid date format',
                ]
            );

            return $validator->validated();
    }
}
