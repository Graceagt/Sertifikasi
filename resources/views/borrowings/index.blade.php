<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Peminjaman - Perpustakaan Arcadia</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    <!-- NAVBAR -->
    <nav class="bg-blue-600 text-white shadow">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex-shrink-0 font-bold text-xl">Perpustakaan Arcadia</div>
                <div class="flex space-x-4">
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
    <div class="max-w-5xl mx-auto p-6 mt-8">

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Riwayat Peminjaman</h1>
        </div>

        <div class="overflow-hidden rounded-lg border border-gray-300 shadow-sm">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="p-3 font-semibold text-gray-700 text-center">ID</th>
                        <th class="p-3 font-semibold text-gray-700 text-center">Tanggal Peminjaman</th>
                        <th class="p-3 font-semibold text-gray-700">Daftar Buku</th>
                        <th class="p-3 font-semibold text-gray-700 text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($borrowings as $borrow)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="p-3 text-center text-gray-700">{{ $borrow->id }}</td>
                            <td class="p-3 text-center text-gray-700">{{ $borrow->borrow_date ?? '-' }}</td>
                            <td class="p-3 text-gray-700">
                                <ul class="list-disc ml-5">
                                    @foreach($borrow->books as $b)
                                        <li>{{ $b->title }} ({{ $b->pivot->quantity }})</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="p-3 text-center">
                                <span class="px-3 py-1 rounded-lg text-sm
                                    @if($borrow->status == 'DIPROSES') bg-yellow-100 text-yellow-700
                                    @elseif($borrow->status == 'DISETUJUI') bg-green-100 text-green-700
                                    @elseif($borrow->status == 'DITOLAK') bg-red-100 text-red-700
                                    @else bg-gray-100 text-gray-600 @endif
                                ">
                                    {{ $borrow->status }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ url('/borrow') }}" 
               class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold shadow transition">
                + Ajukan Peminjaman Baru
            </a>
        </div>

    </div>

</body>
</html>
