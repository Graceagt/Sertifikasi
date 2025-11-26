<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $books = Book::all();

        $borrowings = Borrowing::with('books')
            ->where('user_id', Auth::id())
            ->get();

        return view('user.dashboard', compact('books', 'borrowings'));
    }
}
