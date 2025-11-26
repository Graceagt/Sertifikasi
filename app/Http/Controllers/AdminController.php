<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrowing;
use App\Models\Book;
use App\Models\User; 

class AdminController extends Controller
{
    // Dashboard admin
    public function index()
    {
        $books = Book::all();
        $borrowings = Borrowing::with('user', 'books')->get();
        return view('admin.dashboard', compact('books', 'borrowings'));
    }

    // Halaman Daftar Peminjaman
    public function borrowings()
    {
        $borrowings = Borrowing::with('user','books')->get();
        return view('admin.borrowings', compact('borrowings'));
    }

    // Approve peminjaman
    public function approve($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $borrowing->status = 'DISETUJUI';
        $borrowing->save();

        return redirect()->back()->with('success', 'Peminjaman disetujui.');
    }

    // Reject peminjaman
    public function reject($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $borrowing->status = 'DITOLAK';
        $borrowing->save();

        return redirect()->back()->with('success', 'Peminjaman ditolak.');
    }

    // Return peminjaman
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

    public function dashboard()
    {
        $totalBooks = Book::count();                // total buku
        $totalUsers = User::where('role', 'user')->count(); // total peminjam (user biasa)
        $totalBorrowings = Borrowing::count();      // total peminjaman
        $pendingBorrowings = Borrowing::where('status', 'DIPROSES')->count(); // peminjaman diproses

        $books = Book::all(); // data buku untuk tabel

        return view('admin.dashboard', compact(
            'totalBooks', 'totalUsers', 'totalBorrowings', 'pendingBorrowings', 'books'
        ));
    }
}
