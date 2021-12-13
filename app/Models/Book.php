<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{

    protected $fillable = [
        'account_id',
        'user_id',
        'title',
        'author',
        'released_at',
        'created_at',
        'updated_at'
    ];


    /**
     * Get the user that added the book
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the account that owns the book
     * @return BelongsTo
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->getAttribute('id');
    }


    /**
     * retrieves the book's title
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->getAttribute('title');
    }

    /**
     * retrieves the book's author
     *
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->getAttribute('author');
    }

    /**
     * retrieves the book's release date
     *
     * @return string
     */
    public function getReleaseDate(): string
    {
        return $this->getAttribute('released_at');
    }

    /**
     * retrieve all existing id's
     *
     * @return array
     */
    public function getIds(): array
    {
        return $this->all()->where('account_id', auth()->user()->getAccountId())->pluck('id')->toArray();
    }
}
