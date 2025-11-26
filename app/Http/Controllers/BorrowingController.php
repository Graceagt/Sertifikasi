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

    public function store(Request $request) {

        // Pastikan data 'books' ada
        if (!$request->has('books')) {
            return back()->with('error', 'Tidak ada buku yang dipilih.');
        }

        // Buat record peminjaman
        $borrowing = Borrowing::create([
            'user_id' => Auth::id(),
            'status' => 'DIPROSES'
        ]);

        // Loop semua input buku
        foreach ($request->books as $book_id => $quantity) {

            // Lewati jika quantity kosong atau 0
            if ($quantity == null || $quantity <= 0) {
                continue;
            }

            BorrowingBook::create([
                'borrowing_id' => $borrowing->id,
                'book_id' => $book_id,
                'quantity' => $quantity
            ]);

            // Kurangi stok buku
            $book = Book::find($book_id);
            $book->stock -= $quantity;
            $book->save();
        }

        return redirect('/borrowings')
            ->with('success', 'Peminjaman berhasil diajukan.');
    }
}
