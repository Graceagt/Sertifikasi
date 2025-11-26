<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Book;
use App\Models\Borrowing;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if($user->isAdmin()){
            $borrowings = Borrowing::with('books.book','user')->get();
            return view('admin.dashboard', compact('borrowings'));
        } else {
            $books = Book::where('stock','>',0)->get();
            return view('user.dashboard', compact('books'));
        }
    }
}
