@extends('layouts.admin')

@section('content')
<div class="container mx-auto mt-8">

    <h2 class="text-3xl font-bold mb-6 text-gray-800">Daftar Peminjaman</h2>

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

    <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">#</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">User</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Buku</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Jumlah</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Tanggal</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Status</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($borrowings as $index => $borrowing)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-3 text-sm text-gray-700">{{ $index + 1 }}</td>
                    <td class="px-6 py-3 text-sm text-gray-700">{{ $borrowing->user->name }}</td>
                    <td class="px-6 py-3 text-sm text-gray-700">
                    @foreach($borrow->books as $b)
                    <li>{{ $b->title }} ({{ $b->pivot->quantity }})</li>
                    @endforeach
                    <td class="px-6 py-3 text-sm text-gray-700">
    <ul class="list-disc pl-5">
        @foreach($borrowing->books as $b)
            <li>{{ $b->title }} ({{ $b->pivot->quantity }})</li>
        @endforeach
    </ul>
</td>
                    <td class="px-6 py-3 text-sm text-gray-700">{{ $borrowing->created_at->format('d-m-Y') }}</td>
                    <td class="px-6 py-3 text-sm">
                        @if($borrowing->status == 'DIPROSES')
                            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-semibold">Diproses</span>
                        @elseif($borrowing->status == 'DISETUJUI')
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">Disetujui</span>
                        @elseif($borrowing->status == 'DITOLAK')
                            <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-semibold">Ditolak</span>
                        @endif
                    </td>
                    <td class="px-6 py-3 text-center flex justify-center gap-2">
                        @if($borrowing->status == 'DIPROSES')
                            <form action="{{ route('admin.borrowings.approve', $borrowing->id) }}" method="POST" class="inline">
                                @csrf
                                <button class="bg-green-600 text-white px-4 py-1 rounded hover:bg-green-700 transition">Setujui</button>
                            </form>
                            <form action="{{ route('admin.borrowings.reject', $borrowing->id) }}" method="POST" class="inline">
                                @csrf
                                <button class="bg-red-600 text-white px-4 py-1 rounded hover:bg-red-700 transition">Tolak</button>
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
@endsection
