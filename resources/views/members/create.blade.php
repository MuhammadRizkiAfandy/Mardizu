<!DOCTYPE html>
<html>
<head>
    <title>Tambah Member Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h1 class="mb-4">Tambah Member Baru</h1>

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

    <form action="{{ route('members.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nama:</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Jenis Kelamin:</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="genderL" value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'checked' : '' }}>
                <label class="form-check-label" for="genderL">Laki-laki</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="genderP" value="Perempuan" {{ old('gender') == 'Perempuan' ? 'checked' : '' }}>
                <label class="form-check-label" for="genderP">Perempuan</label>
            </div>
        </div>
                <div class="mb-3">
            <label class="form-label">Tempat Lahir:</label>
            <input type="text" name="birth_place" class="form-control" value="{{ old('birth_place', $member->birth_place ?? '') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Tanggal Lahir:</label>
            <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date', $member->birth_date ?? '') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Email:</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Telepon:</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</body>
</html>
