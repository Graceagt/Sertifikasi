<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Perpustakaan Arcadia</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    <!-- NAVBAR -->
    <nav class="bg-blue-600 text-white shadow">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex-shrink-0 font-bold text-xl">Perpustakaan Arcadia</div>
                <div class="flex space-x-4 items-center">
                    <a href="{{ url('/user/dashboard') }}" class="px-3 py-2 rounded-md hover:bg-blue-500 transition">Dashboard</a>
                    <a href="{{ url('/borrow') }}" class="px-3 py-2 rounded-md hover:bg-blue-500 transition">Pinjam Buku</a>
                    <a href="{{ url('/borrowings') }}" class="px-3 py-2 rounded-md hover:bg-blue-500 transition">Riwayat Peminjaman</a>

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-3 py-2 rounded-md hover:bg-blue-500 transition">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <div class="container mx-auto mt-8">

        <h2 class="text-2xl font-bold mb-4">Selamat datang, {{ Auth::user()->name }}!</h2>

        <!-- Notifikasi status peminjaman -->
        @if(session('status_message'))
            <div id="status-alert" class="bg-yellow-100 text-yellow-800 p-3 mb-4 rounded">
                {{ session('status_message') }}
            </div>
            <script>
                setTimeout(() => {
                    const alert = document.getElementById('status-alert');
                    if(alert){
                        alert.style.transition = "opacity 0.5s ease-out";
                        alert.style.opacity = "0";
                        setTimeout(() => alert.remove(), 500);
                    }
                }, 3000);
            </script>
        @endif

        <!-- Tombol aksi -->
        <div class="flex justify-between mb-6">
            <a href="{{ url('/borrow') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Pinjam Buku</a>
            <a href="{{ url('/borrowings') }}" 
               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Daftar Peminjaman</a>
        </div>

        <!-- Buku tersedia -->
        <h3 class="text-xl font-semibold mb-3">Buku Tersedia</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-6">
            @foreach($books as $book)
                <div class="bg-white p-4 rounded shadow">
                    <h4 class="font-bold">{{ $book->title }}</h4>
                    <p class="text-gray-600">Penulis: {{ $book->author }}</p>
                    <p class="text-gray-600">Stok: {{ $book->stock }}</p>
                </div>
            @endforeach
        </div>

        <!-- Daftar peminjaman -->
        <h3 class="text-xl font-semibold mb-3">Daftar Peminjaman Anda</h3>
        @if($borrowings->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded shadow">
                    <thead>
                        <tr class="bg-gray-200 text-gray-700">
                            <th class="py-2 px-4">#</th>
                            <th class="py-2 px-4">Buku</th>
                            <th class="py-2 px-4">Tanggal Peminjaman</th>
                            <th class="py-2 px-4">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($borrowings as $index => $borrowing)
                            <tr class="border-b">
                                <td class="py-2 px-4">{{ $index + 1 }}</td>
                                <td class="py-2 px-4">
                                    @foreach($borrowing->books as $book)
                                        {{ $book->title }}@if(!$loop->last), @endif
                                    @endforeach
                                </td>
                                <td class="py-2 px-4">{{ $borrowing->created_at->format('d-m-Y') }}</td>
                                <td class="py-2 px-4">
                                    @if($borrowing->status == 'DIPROSES')
                                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded">Diproses</span>
                                    @elseif($borrowing->status == 'DISETUJUI')
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded">Disetujui</span>
                                    @elseif($borrowing->status == 'DITOLAK')
                                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded">Ditolak</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-600">Anda belum memiliki peminjaman.</p>
        @endif

    </div>

</body>
</html>
