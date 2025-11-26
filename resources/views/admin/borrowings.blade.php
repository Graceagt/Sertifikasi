<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Daftar Peminjaman</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

<!-- Navbar Admin -->
<nav class="bg-blue-600 text-white shadow">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <div class="flex-shrink-0 font-bold text-xl">Admin - Perpustakaan Arcadia</div>
            <div class="flex space-x-4 items-center">
                <a href="{{ route('admin.dashboard') }}" 
                   class="px-3 py-2 rounded-md hover:bg-blue-500 transition">Dashboard</a>
                <a href="{{ route('admin.borrowings.index') }}" 
                   class="px-3 py-2 rounded-md hover:bg-blue-500 transition">Daftar Peminjaman</a>

                <!-- Logout -->
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-3 py-2 rounded-md hover:bg-blue-500 transition">Logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>

<div class="container mx-auto mt-8 p-6 bg-white rounded-lg shadow-lg">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Daftar Peminjaman</h1>
        <a href="{{ route('admin.dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded shadow transition">
            ← Back
        </a>
    </div>

    @if(session('success'))
        <div id="success-alert" class="bg-green-100 text-green-800 p-3 mb-4 rounded shadow">
            {{ session('success') }}
        </div>
        <script>
            setTimeout(() => {
                const alert = document.getElementById('success-alert');
                if(alert){
                    alert.style.transition = "opacity 0.5s ease-out";
                    alert.style.opacity = "0";
                    setTimeout(() => alert.remove(), 500);
                }
            }, 3000);
        </script>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-3 text-sm font-medium text-gray-700 border">ID</th>
                    <th class="p-3 text-sm font-medium text-gray-700 border">Peminjam</th>
                    <th class="p-3 text-sm font-medium text-gray-700 border">Buku</th>
                    <th class="p-3 text-sm font-medium text-gray-700 border">Status</th>
                    <th class="p-3 text-sm font-medium text-gray-700 border">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($borrowings as $borrow)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-3 text-sm text-gray-700 border">{{ $borrow->id }}</td>
                        <td class="p-3 text-sm text-gray-700 border">{{ $borrow->user->name }}</td>
                        <td class="p-3 text-sm text-gray-700 border">
                            <ul class="list-disc pl-5">
                                @foreach($borrow->books as $b)
                                    <li>{{ $b->title }} ({{ $b->pivot->quantity }})</li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="p-3 text-sm border">
                            @php
                                $statusColors = [
                                    'DIPROSES' => 'bg-yellow-100 text-yellow-800',
                                    'DISETUJUI' => 'bg-green-100 text-green-800',
                                    'DITOLAK' => 'bg-red-100 text-red-800',
                                    'DIKEMBALIKAN' => 'bg-gray-100 text-gray-700'
                                ];
                            @endphp
                            <span class="{{ $statusColors[$borrow->status] ?? 'bg-gray-100 text-gray-700' }} px-3 py-1 rounded-full text-xs font-semibold">
                                {{ ucfirst(strtolower($borrow->status)) }}
                            </span>
                        </td>
                        <td class="p-3 text-sm border flex flex-wrap gap-2 justify-center">
                            @if($borrow->status == 'DIPROSES')
                                <form action="{{ route('admin.borrowings.approve', $borrow->id) }}" method="POST">
                                    @csrf
                                    <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded transition">✅ Setuju</button>
                                </form>
                                <form action="{{ route('admin.borrowings.reject', $borrow->id) }}" method="POST">
                                    @csrf
                                    <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded transition">❌ Tolak</button>
                                </form>
                            @elseif($borrow->status == 'DISETUJUI')
                                <form action="{{ route('admin.borrowings.return', $borrow->id) }}" method="POST">
                                    @csrf
                                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded transition">📦 Kembalikan</button>
                                </form>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

</body>
</html>
