<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pinjam Buku - Perpustakaan Arcadia</title>
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

                    <form action="{{ url('/logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-3 py-2 rounded-md hover:bg-blue-500 transition">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <div class="max-w-4xl mx-auto mt-12">
        
        <!-- HEADER CARD -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-500 text-white p-8 rounded-2xl shadow-lg">
            <h1 class="text-3xl font-bold tracking-wide">Peminjaman Buku</h1>
            <p class="mt-2 text-blue-100 text-sm">
                Pilih buku yang ingin dipinjam, lalu tentukan jumlah yang diperlukan.
            </p>
        </div>

        <!-- MAIN CARD -->
        <div class="bg-white mt-8 p-10 rounded-2xl shadow-xl border border-gray-200">

            <form action="{{ route('borrowings.store') }}" method="POST">
                @csrf

                <div class="overflow-x-auto shadow-sm rounded-xl border border-gray-200">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b">
                                <th class="p-4 text-left font-semibold text-gray-700">Pilih</th>
                                <th class="p-4 text-left font-semibold text-gray-700">Judul Buku</th>
                                <th class="p-4 text-left font-semibold text-gray-700">Pengarang</th>
                                <th class="p-4 text-center font-semibold text-gray-700">Stok</th>
                                <th class="p-4 text-center font-semibold text-gray-700">Jumlah</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white">
                            @foreach($books as $book)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="p-4">
                                    <input 
                                        type="checkbox"
                                        name="checked_books[]"
                                        value="{{ $book->id }}"
                                        class="w-5 h-5 accent-blue-600 rounded-md cursor-pointer shadow"
                                    >
                                </td>

                                <td class="p-4 font-medium text-gray-900">{{ $book->title }}</td>
                                <td class="p-4 text-gray-700">{{ $book->author }}</td>
                                <td class="p-4 text-center text-gray-800 font-semibold">{{ $book->stock }}</td>
                                <td class="p-4 text-center">
                                    <input 
                                        type="number"
                                        name="quantity[{{ $book->id }}]"
                                        min="1"
                                        max="{{ $book->stock }}"
                                        value="1"
                                        class="w-24 p-2 border rounded-lg bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-400 transition"
                                    >
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <button 
                    type="submit"
                    class="mt-8 w-full bg-green-600 text-white py-3.5 rounded-xl font-semibold text-lg shadow hover:bg-green-700 transition">
                    Ajukan Peminjaman
                </button>
            </form>

            <div class="text-center mt-6">
                <a href="{{ url('/borrowings') }}"
                class="text-blue-700 font-medium hover:underline">
                    Lihat Riwayat Peminjaman
                </a>
            </div>

        </div>
    </div>

</body>
</html>
