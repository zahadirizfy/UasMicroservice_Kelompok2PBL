@extends('backend.layouts.main')
@section('title', 'Manajemen User')
@section('navMhs', 'active') {{-- Ganti nav yang sesuai jika ada nav khusus untuk User --}}

@section('content')
    <div class="text-center mb-4">
        <h2>Manajemen User</h2>
        <hr>
    </div>

    @if (session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 10px; border-radius: 5px;">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div style="background-color: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 10px; border-radius: 5px;">
            {{ session('error') }}
        </div>
    @endif

    <table id="example" class="table table-bordered table-striped mt-3 text-center">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Nomor HP</th>
                <th>Role</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone_number }}</td>
                    <td>{{ ucfirst($user->role) }}</td>
                    <td>{{ $user->is_approved ? 'Disetujui' : 'Belum Disetujui' }}</td>
                    <td>
                        <form action="{{ route('backend.users.destroy', $user->id) }}" method="POST" style="display:inline;"
                            onsubmit="return handleDeleteUser('{{ $user->role }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        function handleDeleteUser(role) {
            const allowedRoles = ['admin'];
            const currentUserRole = @json(Auth::user()->role);

            if (!allowedRoles.includes(currentUserRole)) {
                alert('Hanya admin yang dapat menghapus user.');
                return false;
            }

            if (role === 'admin') {
                alert('User dengan role admin tidak bisa dihapus.');
                return false;
            }

            return confirm('Yakin ingin menghapus user ini?');
        }
    </script>
@endsection
