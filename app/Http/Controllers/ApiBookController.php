<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Book;
use App\Models\Rental;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\DB;



class ApiBookController extends Controller
{


    public function SearchBook(Request $request)
    {
        $query = Book::with('genre');
        
         if (!$request->has('title') && !$request->has('genre') ){
            return response()->json([
                'status' => 'error',
                'message' => 'title or genre is required!!!'
                
            ]);
        }

        if ($request->has('title')) {
            $query->where('title', 'LIKE', '%' . $request->title . '%');
        }
        if ($request->has('genre')) {
        
            $query->whereHas('genre', function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->genre . '%');
            });
        }       
       
        
    
        return response()->json($query->get());
    }

public function RentBook(Request $request)
{
   
    if ($request->has('title') && $request->has('user_name')) {

        $check_book=Book::where('title', $request->title)->first();
        $check_user=Users::where('name', $request->user_name)->first();

        if(!isset($check_book))
        {
        return response()->json([
        'status' => 'error',
        'message' => 'Title does not exists!!!'

        ]);
        }

    if(!isset($check_user))
    {
        return response()->json([
        'status' => 'error',
        'message' => 'User does not exists!!! '

        ]);
    }

    $book = DB::table('books as b')
    ->join('rentals as r', 'b.id', '=', 'r.book_id')
    ->select('b.id as book_id', 'b.title', 'r.id as rental_id', 'r.rented_at', 'r.due_at','r.returned_at')
    ->where('b.title', $request->title)
    ->orderBy('r.rented_at', 'desc')
    ->first();


    if (isset($book) && is_null($book->returned_at)) {
    
        return response()->json([
        'status' => 'error',
        'message' => 'Book is not available for rent!!!'
        ]);

    }
    $rental = new Rental([
        'book_id' => $check_book->id,
        'user_id' => $check_user->id,
        'rented_at' => now(),
        'due_at' => now()->addWeeks(2),
        ]);
        
        $rental->save();
        return response()->json([
            'status' => 'Success',
            'message' => $request->title.' is assigned to '.$request->user_name.". Due date is on ".now()->addWeeks(2)
    
            ]);

    }else{
        return response()->json([
        'status' => 'error',
        'message' => 'title and user_name both are required!!!'

        ]);
    }

}
public function ReturnBook(Request $request)
{
   
    if ($request->has('title') && $request->has('user_name')) {

        $check_book=Book::where('title', $request->title)->first();
        $check_user=Users::where('name', $request->user_name)->first();

        if(!isset($check_book))
        {
        return response()->json([
        'status' => 'error',
        'message' => 'Title does not exists!!!'

        ]);
        }

    if(!isset($check_user))
    {
        return response()->json([
        'status' => 'error',
        'message' => 'User does not exists!!! Please choose Varsha , Tom or Sonu as user_name'

        ]);

    }

    $book = DB::table('books as b')
    ->join('rentals as r', 'b.id', '=', 'r.book_id') 
    ->join('users as u', 'r.user_id', '=', 'u.id')    
    ->select('b.id as book_id', 'b.title', 'r.id as rental_id', 'r.rented_at', 'r.due_at','r.returned_at')
    ->where('b.title', $request->title)
    ->where('u.name', $request->user_name)
    ->orderBy('r.rented_at', 'desc')
    ->first();

    

    if (isset($book) && is_null($book->returned_at)) {
       
        $rental = Rental::findOrFail($book->rental_id);

        $rental->update([
            'returned_at' => now()            
        ]);

        return response()->json([
            'status' => 'Success',
            'message' => $request->title.' is returned by '.$request->user_name.". on ".now()
    
            ]);

    }else{
        
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid Request!!! Either Book is not assigned to given user or it is not valid for return request!!!'
    
            ]);
    }

   
    }else{
        return response()->json([
        'status' => 'error',
        'message' => 'title and user_name both are required!!!'

        ]);
    }

}

public function BookRentalHistory(Request $request)
{

    
    if ($request->has('title')) {

        $check_book=Book::where('title', $request->title)->first();
       
        if(!isset($check_book))
        {
        return response()->json([
        'status' => 'error',
        'message' => 'Title does not exists!!!'

        ]);
        }
     
        $rentals = DB::table('books as b')
        ->join('rentals as r', 'b.id', '=', 'r.book_id') 
        ->join('users as u', 'r.user_id', '=', 'u.id')    
        ->select('b.id as book_id', 'b.title', 'u.id as user id','u.name as user name ','r.id as rental_id', 'r.rented_at', 'r.due_at','r.returned_at')
        ->where('b.title', $request->title)
        //->where('u.name', $request->user_name)
        ->orderBy('r.rented_at', 'desc')
        ->get();

        // Return the rental history as a JSON response
        return response()->json($rentals);




    }else{
        return response()->json([
        'status' => 'error',
        'message' => 'title is required!!!'

        ]);
    }


}

public function UserRentalHistory(Request $request)
{

    if ($request->has('user_name')) {

        $check_user=Users::where('name', $request->user_name)->first();

       
        if(!isset($check_user))
        {
        return response()->json([
        'status' => 'error',
        'message' => 'User does not exists!!!'

        ]);
        }
     
        $rentals = DB::table('books as b')
        ->join('rentals as r', 'b.id', '=', 'r.book_id') 
        ->join('users as u', 'r.user_id', '=', 'u.id')    
        ->select('u.id as user id','u.name as user name ','b.id as book_id', 'b.title', 'r.id as rental_id', 'r.rented_at', 'r.due_at','r.returned_at')
        ->where('u.name', $request->user_name)
        ->orderBy('r.rented_at', 'desc')
        ->get();

        // Return the rental history as a JSON response
        return response()->json($rentals);




    }else{
        return response()->json([
        'status' => 'error',
        'message' => 'user_name is required!!!'

        ]);
    }

}


public function BookStats()
{
    $mostOverdueBook = Rental::where('overdue', '1')
                             ->with('book')
                             ->orderBy('due_at', 'asc')
                             ->first();

    $mostPopularBook = Book::withCount('rentals')
                           ->orderBy('rentals_count', 'desc')
                           ->first();

    $books = Book::leftJoin('rentals', 'books.id', '=', 'rentals.book_id')
    ->whereNull('rentals.book_id')
    ->select('books.*')
    ->selectRaw('0 as rentals_count') 
    ->get();

    if(isset($books[0]) && !is_null($books[0]->id))
    {
        $leastPopularBook=$books;
    }else{
    $leastPopularBook = Book::select('books.*')
                        ->selectRaw('(select count(*) from rentals where books.id = rentals.book_id) as rentals_count')
                        ->havingRaw('rentals_count = (select min(rentals_count) from (select count(*) as rentals_count 
                        from rentals group by book_id) as counts)')
                        ->get();
    }

    return response()->json([
        'most_overdue_book' => isset($mostOverdueBook->book) ? $mostOverdueBook->book: null,
        'most_popular_book' => isset($mostPopularBook) ? $mostPopularBook : null,
        'least_popular_book' => isset($leastPopularBook) ? $leastPopularBook : null,
    ]);
}

}