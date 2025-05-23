<!DOCTYPE html>
<html>
<head>
    <title>Daftar Member</title>
</head>
<body>
    <h1>Daftar Member</h1>

    <a href="{{ route('members.create') }}">Tambah Member Baru</a>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <table border="1" cellpadding="5" cellspacing="0" style="margin-top: 10px;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Telepon</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($members as $member)
            <tr>
                <td>{{ $member->id }}</td>
                <td><a href="{{ route('members.show', $member->id) }}">{{ $member->name }}</a></td>
                <td>{{ $member->email }}</td>
                <td>{{ $member->phone }}</td>
                <td>
                    <a href="{{ route('members.edit', $member->id) }}">Edit</a> |
                    <form action="{{ route('members.destroy', $member->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Yakin ingin menghapus member ini?')" type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center;">Belum ada data member.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
