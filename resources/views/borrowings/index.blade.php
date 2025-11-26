<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Peminjaman - Perpustakaan Arcadia</title>

    <!-- CDN Tailwind yang benar -->
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="bg-gray-100 min-h-screen p-6 flex items-center justify-center">
    
    <div class="w-full max-w-5xl bg-white p-8 rounded-xl shadow-lg border border-gray-200">
        
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Riwayat Peminjaman</h1>

            <a href="{{ url('/user/dashboard') }}" 
               class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg text-gray-700 text-sm font-semibold transition">
                ← Kembali
            </a>
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
                            <td class="p-3 text-center text-gray-700">
                                {{ $borrow->borrow_date ?? '-' }}
                            </td>
                            <td class="p-3 text-gray-700">
                                <ul class="list-disc ml-5">
                                    @foreach($borrow->books as $b)
                                        <li>{{ $b->book->title }} ({{ $b->quantity }})</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="p-3 text-center">
                                <span class="px-3 py-1 rounded-lg text-sm
                                    @if($borrow->status == 'DIPROSES')
                                        bg-yellow-100 text-yellow-700
                                    @elseif($borrow->status == 'DISETUJUI')
                                        bg-green-100 text-green-700
                                    @elseif($borrow->status == 'DITOLAK')
                                        bg-red-100 text-red-700
                                    @else
                                        bg-gray-100 text-gray-600
                                    @endif
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
