<!DOCTYPE html>
<html>
<head>
    <title>Tambah Member Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Muat data provinsi saat halaman dimuat
    fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')
        .then(response => response.json())
        .then(data => {
            let provinceSelect = document.getElementById('province');
            data.forEach(function (prov) {
                let option = document.createElement('option');
                option.value = prov.id;
                option.text = prov.name;
                provinceSelect.appendChild(option);
            });
        });

    // Saat provinsi dipilih, muat kabupaten/kota
    document.getElementById('province').addEventListener('change', function () {
        let provId = this.value;
        let regencySelect = document.getElementById('regency');
        regencySelect.innerHTML = '<option value="">-- Pilih Kabupaten/Kota --</option>';

        if (provId) {
            fetch('https://www.emsifa.com/api-wilayah-indonesia/api/regencies/' + provId + '.json')
                .then(response => response.json())
                .then(data => {
                    data.forEach(function (regency) {
                        let option = document.createElement('option');
                        option.value = regency.id;
                        option.text = regency.name;
                        regencySelect.appendChild(option);
                    });
                });
        }
    });
});
</script>
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
            <label class="form-label">No KTP:</label>
            <input type="text" name="no_ktp" class="form-control" value="{{ old('no_ktp', $member->no_ktp ?? '') }}" maxlength="16" required>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label class="form-label">Tinggi Badan (cm):</label>
                <input type="number" name="height" class="form-control" value="{{ old('height', $member->height ?? '') }}" min="0">
            </div>
            <div class="col">
                <label class="form-label">Berat Badan (kg):</label>
                <input type="number" name="weight" class="form-control" value="{{ old('weight', $member->weight ?? '') }}" min="0">
            </div>
        </div>
            <div class="mb-3">
            <label class="form-label">Telepon:</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Email:</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Provinsi:</label>
                <select id="province" name="province_id" class="form-select" required>
                    <option value="">-- Pilih Provinsi --</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Kabupaten/Kota:</label>
                <select id="regency" name="regency_id" class="form-select" required>
                    <option value="">-- Pilih Kabupaten/Kota --</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</body>
</html>
