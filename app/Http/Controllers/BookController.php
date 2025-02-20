<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Block;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        return view('pages.book.index', [
            'books' => Book::with( 'authors', 'publisher', 'block')
                ->withCount('available_copies')
                ->when(
                    \request()->has('search'),
                    fn(Builder $q) => $q->where('name', 'like', '%'.\request()->search.'%')
                )
                ->paginate(10)
                ->withQueryString()
        ]);
    }

    public function create()
    {
        return view('pages.book.edit', [
            'authors' => Author::all()->pluck('full_name', 'id'),
            'publishers' => Publisher::all()->pluck('name', 'id'),
            'blocks' => Block::all()->pluck('code', 'id'),
            'categories' => Category::all()->pluck('name', 'id')
        ]);
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $book = Book::create($request->only([
            'name',
            'isbn',
            'publisher_id',
            'block_id'
        ]));
        $book->categories()->sync($request->categories);
        $book->authors()->sync($request->authors);
        $book->copies()->createMany(array_fill(0, $request->count, ['edition' => $request->edition]));
        return redirect()
            ->route('book.edit', $book->id)
            ->with('success', 'Kitap eklendi.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        //
    }

    public function edit(Book $book)
    {
        return view('pages.book.edit', [
            'book' => $book,
            'copies' => $book->copies,
            'authors' => Author::all()->pluck('name', 'id'),
            'selectedAuthors' => $book->authors->pluck('id')->toArray(),
            'publishers' => Publisher::all()->pluck('name', 'id'),
            'blocks' => Block::all()->pluck('code', 'id'),
            'categories' => Category::all()->pluck('name', 'id'),
            'selectedIds' => $book->categories->pluck('id')->toArray(),
        ]);
    }

    public function update(Request $request, Book $book): \Illuminate\Http\RedirectResponse
    {
        $book->update($request->only([
            'name',
            'isbn',
            'publisher_id',
            'block_id'
        ]));
        $book->categories()->sync($request->categories);
        $book->authors()->sync($request->authors);
        return back()->with('success', 'Kitap kaydedildi');
    }

    public function destroy(Book $book): \Illuminate\Http\RedirectResponse
    {
        $book->delete();
        return redirect()
            ->route('book.index')
            ->with('success', 'Kitap silindi.');
    }
}
