<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Book;
use App\Repositories\BooksRepository;
use App\Services\BooksService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class BooksController extends Controller
{
    /**
     * @var Book
     */
    private $book;

    /**
     * @var BooksService
     */
    private $booksService;
    /**
     * @var BooksRepository
     */
    private $booksRepository;

    public function __construct(
        Book $book,
        BooksService $booksService,
        BooksRepository $booksRepository
    )
    {
        $this->book            = $book;
        $this->booksService    = $booksService;
        $this->booksRepository = $booksRepository;
    }

    /**
     * @param Request $request
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        if ($request->user()->cannot('viewAny', $this->book)) {
            abort(403);
        }

        $accountId = $request->user()->getAccountId();

        $books = $this->booksRepository->listBooks($accountId);

        return view('books.index', ['books' => $books]);

    }

    /**
     * @param Request $request
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View|View
     */
    public function create(Request $request)
    {
        if ($request->user()->cannot('create', $this->book)) {
            abort(403);
        }

        return view('books.add_book');
    }

    /**
     * @param Request $request
     *
     * @return Application|RedirectResponse|Redirector
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        if ($request->user()->cannot('create', $this->book)) {
            abort(403);
        }
        $validatedBook = $this->booksService->validateInput($request->all());
        $this->booksRepository->addBook($validatedBook);

        return redirect('/books');
    }

    /**
     * @param Request $request
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy(Request $request)
    {
        if ($request->user()->cannot('delete', $this->book)) {
            abort(403);
        }

        $this->booksRepository->deleteBook($request->route()->parameter('bookId'));

        return redirect('/books');
    }
}
