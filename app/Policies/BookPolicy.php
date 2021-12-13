<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class BookPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @return Response|bool
     */
    public function viewAny()
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Book $book
     *
     * @return Response|bool
     */
    public function view(User $user, Book $book)
    {
        return $user->account_id === $book->account_id
            ? Response::allow()
            : Response::deny("This book doesn't belong to your account");
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     *
     * @return Response|bool
     */
    public function create(User $user)
    {
        return $user->account_id === auth()->user()->account_id
            ? Response::allow()
            : Response::deny("You can add books only to your account");
    }


    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     *
     * @return Response|bool
     */
    public function delete(User $user)
    {
        return $user->account_id === auth()->user()->account_id
            ? Response::allow()
            : Response::deny("This book doesn't belong to your account");
    }
}
