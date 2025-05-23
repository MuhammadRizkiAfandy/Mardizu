<!DOCTYPE html>
<html>
<head>
    <title>Edit Member</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h1 class="mb-4">Edit Member</h1>

    <a href="{{ route('members.index') }}" class="btn btn-secondary mb-3">← Kembali ke Daftar Member</a>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Oops! Ada masalah dengan input:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('members.update', $member->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama:</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $member->name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email:</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $member->email) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Telepon:</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $member->phone) }}">
        </div>

        <button type="submit" class="btn btn-primary">Perbarui</button>
    </form>
</body>
</html>
