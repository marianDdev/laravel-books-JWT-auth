<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Repositories\BooksRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BooksApiController extends Controller
{
    /**
     * @var BooksRepository
     */
    private $booksRepository;
    /**
     * @var Book
     */
    private $book;

    public function __construct(
        Book $book,
        BooksRepository $booksRepository
    )
    {
        $this->booksRepository = $booksRepository;
        $this->book            = $book;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function fetchBooks(Request $request): JsonResponse
    {
        if ($request->user()->cannot('viewAny', $this->book)) {
            abort(403);
        }

        $accountId = $request->user()->getAccountId();
        $books     = $this->booksRepository->listBooks($accountId);

        return response()->json($books);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse|string
     */
    public function getBook(Request $request)
    {
        $id        = $request->route()->parameter('bookId');
        $accountId = $request->user()->getAccountId();
        $book      = $this->booksRepository->getBook($accountId, $id);

        if (!is_null($book)) {
            return response()->json($book);
        }

        return sprintf(
            "This book doesn't belong to your account. Here's a list with the available books id's: %s",
            implode(", ",$this->book->getIds())
        );
    }
}
