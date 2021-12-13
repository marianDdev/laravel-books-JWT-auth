<?php

namespace App\Repositories;

use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BooksRepository
{
    /**
     * @param array $book
     */
    public function addBook(array $book)
    {
        Book::create(
            [
                'account_id'  => auth()->user()->account_id,
                'user_id'     => auth()->user()->id,
                'title'       => $book['title'],
                'author'      => $book['author'],
                'released_at' => $book['released_at'],
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ]
        );
    }

    /**
     * @param int $accountId
     *
     * @return LengthAwarePaginator
     */
    public function listBooks(int $accountId): LengthAwarePaginator
    {
        return Book::where('account_id', $accountId)
                   ->orderByDesc('id')
                   ->paginate(5);
    }

    /**
     * @param int $id
     */
    public function deleteBook(int $id)
    {
        Book::where('id', $id)->delete();
    }

    /**
     * @param int $accountId
     * @param int $id
     *
     * @return mixed
     */
    public function getBook(int $accountId, int $id)
    {
        return Book::where('account_id', $accountId)
                   ->where('id', $id)
                   ->first();
    }
}
