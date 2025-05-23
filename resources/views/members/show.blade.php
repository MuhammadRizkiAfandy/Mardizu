<!DOCTYPE html>
<html>
<head>
    <title>Detail Member</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h1 class="mb-4">Detail Member</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $member->name }}</h5>
            <p class="card-text"><strong>Jenis Kelamin:</strong> {{ $member->gender }}</p>
            <p class="card-text"><strong>Tempat Lahir:</strong> {{ $member->birth_place ?? '-' }}</p>
            <p class="card-text"><strong>Tanggal Lahir:</strong> {{ $member->birth_date ?? '-' }}</p>
            <p class="card-text"><strong>No KTP:</strong> {{ $member->no_ktp }}</p>
            <p class="card-text"><strong>Tinggi Badan:</strong> {{ $member->height }} cm</p>
            <p class="card-text"><strong>Berat Badan:</strong> {{ $member->weight }} kg</p>
            <p class="card-text"><strong>Email:</strong> {{ $member->email }}</p>
            <p class="card-text"><strong>Telepon:</strong> {{ $member->phone ?? '-' }}</p>
        </div>
    </div>

    <a href="{{ route('members.index') }}" class="btn btn-secondary mt-3">← Kembali ke Daftar Member</a>
</body>
</html>
