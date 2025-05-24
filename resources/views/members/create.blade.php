<!DOCTYPE html>
<html>
<head>
    <title>Tambah Member Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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

    <form action="{{ route('members.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="vaccine_certificate" class="form-label">Upload Sertifikat Vaksin (PDF):</label>
            <input type="file" name="vaccine_certificate" id="vaccine_certificate" class="form-control" accept=".pdf*" onchange="previewVaccineCertificate()">
            <small class="form-text text-muted">Maksimal ukuran 2MB. Format: PDF</small>
        </div>

        <div class="mb-3" id="vaccine-preview-container">
            <div id="vaccine-placeholder">Belum ada preview.</div>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Nama:</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Jenis Kelamin:</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="genderL" value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'checked' : '' }} required>
                <label class="form-check-label" for="genderL">Laki-laki</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="genderP" value="Perempuan" {{ old('gender') == 'Perempuan' ? 'checked' : '' }} required>
                <label class="form-check-label" for="genderP">Perempuan</label>
            </div>
        </div>

        <div class="mb-3">
            <label for="birth_place" class="form-label">Tempat Lahir:</label>
            <input type="text" name="birth_place" id="birth_place" class="form-control" value="{{ old('birth_place') }}">
        </div>

        <div class="mb-3">
            <label for="birth_date" class="form-label">Tanggal Lahir:</label>
            <input type="date" name="birth_date" id="birth_date" class="form-control" value="{{ old('birth_date') }}">
        </div>

        <div class="mb-3">
            <label for="no_ktp" class="form-label">No KTP:</label>
            <input type="text" name="no_ktp" id="no_ktp" class="form-control" value="{{ old('no_ktp') }}" maxlength="16" required pattern="\d{16}" title="Masukkan 16 digit angka">
        </div>

        <div class="row mb-3">
            <div class="col">
                <label for="height" class="form-label">Tinggi Badan (cm):</label>
                <input type="number" name="height" id="height" class="form-control" value="{{ old('height') }}" min="0">
            </div>
            <div class="col">
                <label for="weight" class="form-label">Berat Badan (kg):</label>
                <input type="number" name="weight" id="weight" class="form-control" value="{{ old('weight') }}" min="0">
            </div>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Telepon:</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" pattern="[0-9]*" title="Masukkan hanya angka">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label for="photo" class="form-label">Upload Foto:</label>
            <input type="file" name="photo" id="photo" class="form-control" accept="image/*" onchange="previewPhoto()" required>
            <small class="form-text text-muted">Format yang didukung: jpg, jpeg, png. Max 2MB.</small>
        </div>

        <div class="mb-3">
            <img id="photo-preview" src="https://via.placeholder.com/200x250?text=Preview+Foto" alt="Preview Foto" class="img-thumbnail" style="max-width: 200px;">
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="province" class="form-label">Provinsi:</label>
                <select id="province" name="province_id" class="form-select" required>
                    <option value="">-- Pilih Provinsi --</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="regency" class="form-label">Kabupaten/Kota:</label>
                <select id="regency" name="regency_id" class="form-select" required>
                    <option value="">-- Pilih Kabupaten/Kota --</option>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label for="graduation_year" class="form-label">Tahun Lulus:</label>
            <select name="graduation_year" id="graduation_year" class="form-select">
                <option value="">-- Pilih Tahun --</option>
                @for ($year = 2000; $year <= 2029; $year++)
                    <option value="{{ $year }}" {{ old('graduation_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endfor
            </select>
        </div>

        <div class="mb-3">
            <label for="experience" class="form-label">Pengalaman Kerja:</label>
            <select name="experience" id="experience" class="form-select" style="width: 100%;">
                @php
                    $experiences = ['Casting', 'Stamping', 'Decal', 'Operator Produksi', 'Molding', 'Machining', 'Assembling', 'Warehouse', 'Quality Control', 'Admin'];
                    $selectedExperience = old('experience', '');
                @endphp
                <option></option>
                @foreach ($experiences as $exp)
                    <option value="{{ $exp }}" {{ $selectedExperience == $exp ? 'selected' : '' }}>
                        {{ $exp }}
                    </option>
                @endforeach
            </select>
            <small class="form-text text-muted">Pilih atau ketik pengalaman kerja Anda.</small>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>

    <!-- Script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
    function previewPhoto() {
        const file = document.getElementById("photo").files[0];
        const preview = document.getElementById("photo-preview");

        if (file) {
            const reader = new FileReader();
            reader.onload = e => preview.src = e.target.result;
            reader.readAsDataURL(file);
        } else {
            preview.src = "https://via.placeholder.com/200x250?text=Preview+Foto";
        }
    }

    function previewVaccineCertificate() {
        const file = document.getElementById("vaccine_certificate").files[0];
        const container = document.getElementById("vaccine-preview-container");

        container.innerHTML = "";

        if (file) {
            if (file.type === "application/pdf") {
                container.innerHTML = `<embed src="${URL.createObjectURL(file)}" type="application/pdf" width="100%" height="400px">`;
            } else if (file.type.startsWith("image/")) {
                container.innerHTML = `<img src="${URL.createObjectURL(file)}" class="img-thumbnail" style="max-width:300px;">`;
            } else {
                container.innerHTML = `<div class="text-danger">Format tidak didukung.</div>`;
            }
        } else {
            container.innerHTML = `<div id="vaccine-placeholder">Belum ada preview.</div>`;
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const provinceSelect = document.getElementById('province');
        const regencySelect = document.getElementById('regency');

        const loadRegencies = (provinceId, selectedRegency = null) => {
            regencySelect.innerHTML = '<option value="">-- Pilih Kabupaten/Kota --</option>';
            if (!provinceId) return;

            fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provinceId}.json`)
                .then(res => res.json())
                .then(data => {
                    data.forEach(reg => {
                        const option = document.createElement('option');
                        option.value = reg.id;
                        option.text = reg.name;
                        regencySelect.appendChild(option);
                    });
                    if (selectedRegency) regencySelect.value = selectedRegency;
                });
        };

        fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')
            .then(res => res.json())
            .then(data => {
                data.forEach(prov => {
                    const option = document.createElement('option');
                    option.value = prov.id;
                    option.text = prov.name;
                    provinceSelect.appendChild(option);
                });

                const oldProvince = "{{ old('province_id') }}";
                if (oldProvince) {
                    provinceSelect.value = oldProvince;
                    loadRegencies(oldProvince, "{{ old('regency_id') }}");
                }
            });

        provinceSelect.addEventListener('change', () => {
            loadRegencies(provinceSelect.value);
        });

        $('#experience').select2({
            placeholder: "Pilih atau ketik pengalaman kerja",
            allowClear: true,
            tags: true
        });
    });
    </script>
</body>
</html>
