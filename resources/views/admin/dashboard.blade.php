<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Perpustakaan Arcadia</title>
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

<div class="container mx-auto mt-8">

    <h2 class="text-2xl font-bold mb-6">Selamat datang, {{ Auth::user()->name }}!</h2>

    <!-- Notifikasi sukses -->
    @if(session('success'))
        <div id="success-alert" class="bg-green-100 text-green-800 p-3 mb-4 rounded">
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


    <!-- Form Tambah Buku -->
    <div class="bg-white p-6 rounded shadow mb-6">
        <h3 class="text-xl font-semibold mb-3">Tambah Buku Baru</h3>
        <form action="{{ url('/admin/books') }}" method="POST" class="space-y-4">
            @csrf
            <input type="text" name="title" placeholder="Judul Buku" class="w-full p-3 border rounded">
            <input type="text" name="author" placeholder="Penulis" class="w-full p-3 border rounded">
            <input type="number" name="stock" placeholder="Stok" class="w-full p-3 border rounded">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Tambah Buku</button>
        </form>
    </div>

    <!-- Tabel Daftar Buku -->
    <div class="bg-white p-6 rounded shadow">
        <h3 class="text-xl font-semibold mb-3">Daftar Buku</h3>
        <table class="min-w-full table-auto">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Judul</th>
                    <th class="px-4 py-2">Penulis</th>
                    <th class="px-4 py-2">Stok</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($books as $index => $book)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $index+1 }}</td>
                        <td class="px-4 py-2">{{ $book->title }}</td>
                        <td class="px-4 py-2">{{ $book->author }}</td>
                        <td class="px-4 py-2">{{ $book->stock }}</td>
                        <td class="px-4 py-2 flex gap-2">
                            <button onclick="openModal({{ $book->id }}, '{{ $book->title }}', '{{ $book->author }}', {{ $book->stock }})"
                                    class="bg-yellow-400 hover:bg-yellow-500 text-white px-2 py-1 rounded">
                                Edit
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<!-- Modal Edit Buku -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded shadow w-full max-w-md">
        <h3 class="text-xl font-semibold mb-3">Edit Buku</h3>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <input type="text" name="title" id="modalTitle" class="w-full p-3 border rounded mb-3">
            <input type="text" name="author" id="modalAuthor" class="w-full p-3 border rounded mb-3">
            <input type="number" name="stock" id="modalStock" class="w-full p-3 border rounded mb-3">
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal()" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">Batal</button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal(id, title, author, stock){
    document.getElementById('editForm').action = '/admin/books/' + id;
    document.getElementById('modalTitle').value = title;
    document.getElementById('modalAuthor').value = author;
    document.getElementById('modalStock').value = stock;
    document.getElementById('editModal').classList.remove('hidden');
}

function closeModal(){
    document.getElementById('editModal').classList.add('hidden');
}
</script>

</body>
</html>
