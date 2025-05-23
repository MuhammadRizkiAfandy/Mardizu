<!DOCTYPE html>
<html>
<head>
    <title>Daftar Member</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h1 class="mb-4">Daftar Member</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('members.create') }}" class="btn btn-success mb-3">+ Tambah Member Baru</a>

    @if ($members->count() > 0)
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Tempat Lahir</th>
                    <th>Tanggal Lahir</th>
                    <th>No KTP</th>
                    <th>Tinggi (cm)</th>
                    <th>Berat (kg)</th>
                    <th>Telepon</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($members as $index => $member)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $member->name }}</td>
                        <td>{{ $member->gender }}</td>
                        <td>{{ $member->birth_place ?? '-' }}</td>
                        <td>{{ $member->birth_date }}</td>
                        <td>{{ $member->no_ktp }}</td>
                        <td>{{ $member->height ?? '-' }}</td>
                        <td>{{ $member->weight ?? '-' }}</td>
                        <td>{{ $member->phone }}</td>
                        <td>{{ $member->email }}</td>
                        <td>
                            <a href="{{ route('members.show', $member->id) }}" class="btn btn-info btn-sm">Detail</a>
                            <a href="{{ route('members.edit', $member->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('members.destroy', $member->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Yakin ingin menghapus?')" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Tidak ada data member.</p>
    @endif
</body>
</html>
