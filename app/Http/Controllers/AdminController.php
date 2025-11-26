<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrowing;
use App\Models\Book;

class AdminController extends Controller
{
      // Dashboard admin
        public function index()
        {
            $books = Book::all(); // ambil semua buku
            $borrowings = Borrowing::with('user', 'books')->get(); // opsional, kalau mau ditampilkan di dashboard juga
    
            return view('admin.dashboard', compact('books', 'borrowings'));
        }

    // Tambahkan ini:
    public function borrowings()
    {
        // ambil semua peminjaman beserta data user dan buku
        $borrowings = Borrowing::with('user','books')->get();
        return view('admin.borrowings', compact('borrowings'));
    }

    public function approve($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $borrowing->status = 'DISETUJUI';
        $borrowing->save();

        return redirect()->back()->with('success', 'Peminjaman disetujui.');
    }

    public function reject($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $borrowing->status = 'DITOLAK';
        $borrowing->save();

        return redirect()->back()->with('success', 'Peminjaman ditolak.');
    }

    public function returnBook($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $borrowing->status = 'DIKEMBALIKAN';
        $borrowing->save();

        return redirect()->back()->with('success', 'Buku berhasil dikembalikan.');
    }

    // Tambah buku baru
    public function storeBook(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'author'=>'required',
            'stock'=>'required|numeric|min:0'
        ]);

        Book::create($request->only('title','author','stock'));

        return redirect()->back()->with('success','Buku berhasil ditambahkan.');
    }

    // Update buku
    public function updateBook(Request $request, $id)
    {
        $request->validate([
            'title'=>'required',
            'author'=>'required',
            'stock'=>'required|numeric|min:0'
        ]);

        $book = Book::findOrFail($id);
        $book->update($request->only('title','author','stock'));

        return redirect()->back()->with('success','Buku berhasil diupdate.');
    }

    
}
