<?php

namespace App\Http\Controllers;
use App\Models\Genre;
use App\Models\Book;
use App\Models\Users;
use Illuminate\Support\Facades\DB;



use Illuminate\Http\Request;


class BookController extends Controller
{
    
    public function list()
    {
        
        $data = DB::table('books')
                ->join('genres', 'books.genre_id', '=', 'genres.id')
                ->leftJoin('rentals', 'books.id', '=', 'rentals.book_id')
                ->leftJoin('users', 'rentals.user_id', '=', 'users.id')
                ->select(
                    'books.*',
                    'genres.name as genre_name',
                    'users.id as userid',
                    'users.name as username',
                    'rentals.id as rentalid',
                    'rentals.rented_at',
                    'rentals.returned_at',
                    'rentals.due_at'
                )
                ->where(function($query) {
                    $query->whereNull('rentals.rented_at')
                        ->orWhere('rentals.rented_at', '=', function($subquery) {
                            $subquery->select(DB::raw('MAX(r.rented_at)'))
                                    ->from('rentals as r')
                                    ->whereColumn('r.book_id', 'books.id');
                        });
                })
                ->get();
                //dd($data);

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

        return view('booklist', ['data' => $data,'bks'=>$bks,'users'=>$users]);
    }
    
    
    
    public function search(Request $request)
    {
        
        $query = Book::query();

        if ($request->filled('name')) {
            $query->where('title', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('genre')) {
            $query->whereHas('genre', function ($q) use ($request) {
                $q->where('name', $request->genre);
            });
        }

        return $query->get();
    }

    

}
