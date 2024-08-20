<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;
use App\Models\Book;
use App\Models\Rental;
use App\Models\Users;
use Illuminate\Support\Facades\DB;


class RentalController extends Controller
{
    public function rentbook(Request $request)
    {
       
        $book = Book::findOrFail($request->book);
        $rental = Rental::create([
            'user_id' => $request->user,
            'book_id' => $book->id,
            'rented_at' => now(),
            'due_at' => now()->addWeeks(2),
        ]);

        return $rental;
    }

    public function returnBook(Request $request)
    {
        $rental = Rental::where('book_id', $request->book_id)
                        ->where('user_id', auth()->id())
                        ->whereNull('returned_at')
                        ->firstOrFail();

        $rental->update([
            'returned_at' => now(),
            'overdue' => $rental->due_at->isPast(),
        ]);

        return $rental;
    }

    public function rentalHistory()
    {
        return Rental::where('user_id', auth()->id())->get();
    }

    public function mostOverdue()
    {
        return Rental::where('overdue', true)
                     ->orderBy('due_at', 'asc')
                     ->first();
    }

    public function mostPopular()
    {
        return Book::withCount('rentals')
                   ->orderBy('rentals_count', 'desc')
                   ->first();
    }

    public function leastPopular()
    {
        return Book::withCount('rentals')
                   ->orderBy('rentals_count', 'asc')
                   ->first();
    }
 
    public function availableBooks()
    {
        $book = Book::with('genre')
        ->whereDoesntHave('rentals', function ($query) {
        $query->whereNull('returned_at');
        })
        ->orWhereHas('rentals', function ($query) {
        $query->whereNotNull('returned_at')
        ->whereColumn('rentals.id', '=', DB::raw('(SELECT MAX(r.id) FROM rentals r WHERE r.book_id = books.id)'));
        })
        ->get();
        $bks = Book::with('genre')
                ->whereDoesntHave('rentals', function ($query) {
                $query->whereNull('returned_at');
                })
                ->orWhereHas('rentals', function ($query) {
                $query->whereNotNull('returned_at')
                ->whereColumn('rentals.id', '=', DB::raw('(SELECT MAX(r.id) FROM rentals r WHERE r.book_id = books.id)'));
                })
                ->get();

        $users=Users::get();

        return view('availablebooks', ['data' => $book,'bks'=>$bks,'users'=>$users]);

   }
}
