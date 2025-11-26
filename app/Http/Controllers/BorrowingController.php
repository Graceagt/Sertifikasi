<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\BorrowingBook;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowingController extends Controller
{
    public function index() {
        $borrowings = Borrowing::where('user_id', Auth::id())
            ->with('books')
            ->get();

        return view('borrowings.index', compact('borrowings'));
    }

    public function create() {
        $books = Book::where('stock', '>', 0)->get();
        return view('borrowings.create', compact('books'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'checked_books' => 'required|array',
            'quantity' => 'required|array',
        ]);
    
        $user = auth()->user();
    
        // Buat data peminjaman baru
        $borrowing = Borrowing::create([
            'user_id' => $user->id,
            'status' => 'DIPROSES',
        ]);
    
        // Loop buku yang dipilih
        foreach($request->checked_books as $bookId) {
            $quantity = $request->quantity[$bookId] ?? 1;
    
            // Simpan ke pivot table
            $borrowing->books()->attach($bookId, ['quantity' => $quantity]);
    
            // Opsional: Kurangi stok buku
            $book = Book::find($bookId);
            $book->stock -= $quantity;
            $book->save();
        }
    
        return redirect()->back()->with('success', 'Peminjaman berhasil diajukan.');
    }
    
}
