<?php

namespace App\Http\Controllers;
use App\Models\Borrowing;

class AdminBorrowingController extends Controller
{
    // Menampilkan semua peminjaman
    public function index()
    {
        $borrowings = Borrowing::with('books','user')
                                ->orderBy('created_at','desc')
                                ->get();

        return view('admin.borrowings.index', compact('borrowings'));
    }

    // Approve peminjaman
    public function approve($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $borrowing->status = 'DISETUJUI';
        $borrowing->save();

        return redirect()->route('admin.borrowings.index')->with('success','Peminjaman disetujui.');
    }

    // Reject peminjaman
    public function reject($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $borrowing->status = 'DITOLAK';
        $borrowing->save();

        // Kembalikan stok buku
        foreach($borrowing->books as $book){
            $book->stock += $book->pivot->quantity;
            $book->save();
        }

        return redirect()->route('admin.borrowings.index')->with('success','Peminjaman ditolak.');
    }
}
