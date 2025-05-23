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
            <p class="card-text"><strong>Email:</strong> {{ $member->email }}</p>
            <p class="card-text"><strong>Telepon:</strong> {{ $member->phone ?? '-' }}</p>
        </div>
    </div>

    <a href="{{ route('members.index') }}" class="btn btn-secondary mt-3">← Kembali ke Daftar Member</a>
</body>
</html>
