<!DOCTYPE html>
<html>
<head>
    <title>Daftar Member</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Jika Select2 tidak digunakan di sini, bisa dihapus --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
</head>
<body class="container mt-5">
    <h1 class="mb-4">Daftar Member</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('members.create') }}" class="btn btn-success mb-3">+ Tambah Member Baru</a>

    @if ($members->count())
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark text-center">
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
                        <th>Provinsi</th>
                        <th>Kabupaten/Kota</th>
                        <th>Tahun Lulus</th>
                        <th>Experience</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($members as $member)
                        <tr>
                            <td class="text-center">{{ $loop->iteration + ($members->currentPage() - 1) * $members->perPage() }}</td>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->gender }}</td>
                            <td>{{ $member->birth_place ?? '-' }}</td>
                            <td class="text-center">
                                {{ $member->birth_date ? \Carbon\Carbon::parse($member->birth_date)->format('d-m-Y') : '-' }}
                            </td>
                            <td>{{ $member->no_ktp }}</td>
                            <td class="text-end">{{ $member->height ?? '-' }}</td>
                            <td class="text-end">{{ $member->weight ?? '-' }}</td>
                            <td>{{ $member->phone ?? '-' }}</td>
                            <td>{{ $member->email }}</td>
                            {{-- Pastikan relasi province dan regency sudah di-load di controller --}}
                            <td>{{ $member->province ?? '-' }}</td>
                            <td>{{ $member->regency ?? '-' }}</td>
                            <td class="text-center">{{ $member->graduation_year ?? '-' }}</td>
                            <td>{{ $member->experience ?? '-' }}</td> 
                            <td class="text-center">
                                <a href="{{ route('members.show', $member->id) }}" class="btn btn-info btn-sm mb-1" aria-label="Detail {{ $member->name }}">Detail</a>
                                <a href="{{ route('members.edit', $member->id) }}" class="btn btn-warning btn-sm mb-1" aria-label="Edit {{ $member->name }}">Edit</a>
                                <form action="{{ route('members.destroy', $member->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm mb-1" aria-label="Hapus {{ $member->name }}">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination jika data banyak --}}
        <div class="mt-3">
            {{ $members->links() }}
        </div>

    @else
        <div class="alert alert-warning">Tidak ada data member.</div>
    @endif

    <!-- JS Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    {{-- Jika Select2 tidak dipakai di halaman ini, script ini bisa dihapus --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
</body>
</html>
