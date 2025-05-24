<!DOCTYPE html>
<html>
<head>
    <title>Edit Member</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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

    <form action="{{ route('members.update', $member->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Sertifikat Vaksin -->
        <div class="mb-3">
            <label for="vaccine_certificate" class="form-label">Upload Sertifikat Vaksin (PDF):</label>
            <input type="file" name="vaccine_certificate" id="vaccine_certificate" class="form-control" accept=".pdf*" onchange="previewVaccineCertificate()">
            <small class="form-text text-muted">Maksimal ukuran 2MB. Format: PDF</small>
        </div>

        <div class="mb-3" id="vaccine-preview-container">
            <div id="vaccine-placeholder">Belum ada preview.</div>
        </div>

        <!-- Nama -->
        <div class="mb-3">
            <label for="name" class="form-label">Nama:</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $member->name) }}" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <!-- Gender -->
        <div class="mb-3">
            <label class="form-label">Jenis Kelamin:</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="genderL" value="Laki-laki" {{ old('gender', $member->gender) == 'Laki-laki' ? 'checked' : '' }} required>
                <label class="form-check-label" for="genderL">Laki-laki</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="genderP" value="Perempuan" {{ old('gender', $member->gender) == 'Perempuan' ? 'checked' : '' }} required>
                <label class="form-check-label" for="genderP">Perempuan</label>
            </div>
        </div>

        <!-- Tempat & Tanggal Lahir -->
        <div class="mb-3">
            <label for="birth_place" class="form-label">Tempat Lahir:</label>
            <input type="text" name="birth_place" id="birth_place" class="form-control" value="{{ old('birth_place', $member->birth_place) }}">
        </div>
        <div class="mb-3">
            <label for="birth_date" class="form-label">Tanggal Lahir:</label>
            <input type="date" name="birth_date" id="birth_date" class="form-control" value="{{ old('birth_date', $member->birth_date ? \Carbon\Carbon::parse($member->birth_date)->format('Y-m-d') : '') }}">
        </div>

        <!-- No KTP -->
        <div class="mb-3">
            <label for="no_ktp" class="form-label">No KTP:</label>
            <input type="text" name="no_ktp" id="no_ktp" class="form-control" value="{{ old('no_ktp', $member->no_ktp) }}" maxlength="16" required pattern="\d{16}" title="Masukkan 16 digit angka">
        </div>

        <!-- Tinggi & Berat -->
        <div class="row mb-3">
            <div class="col">
                <label for="height" class="form-label">Tinggi Badan (cm):</label>
                <input type="number" name="height" id="height" class="form-control" value="{{ old('height', $member->height) }}" min="0">
            </div>
            <div class="col">
                <label for="weight" class="form-label">Berat Badan (kg):</label>
                <input type="number" name="weight" id="weight" class="form-control" value="{{ old('weight', $member->weight) }}" min="0">
            </div>
        </div>

        <!-- Telepon & Email -->
        <div class="mb-3">
            <label for="phone" class="form-label">Telepon:</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $member->phone) }}" pattern="[0-9]*" title="Masukkan hanya angka">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $member->email) }}" required>
        </div>

        <!-- Upload & Preview Foto -->
        <div class="mb-3">
            <label for="photo" class="form-label">Upload Foto:</label>
            <input type="file" name="photo" id="photo" class="form-control" accept="image/*" onchange="previewPhoto()">
            <small class="form-text text-muted">Format: jpg, jpeg, png. Max 2MB.</small>
        </div>
        <div class="mb-3">
            <img id="photo-preview" src="{{ $member->photo ? asset('storage/' . $member->photo) : 'https://via.placeholder.com/200x250?text=Preview+Foto' }}" alt="Preview Foto" class="img-thumbnail" style="max-width: 200px;">
        </div>

        <!-- Provinsi dan Kabupaten -->
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

        <!-- Tahun Lulus -->
        <div class="mb-3">
            <label for="graduation_year" class="form-label">Tahun Lulus:</label>
            <select name="graduation_year" id="graduation_year" class="form-select">
                <option value="">-- Pilih Tahun --</option>
                @for ($year = 2000; $year <= 2029; $year++)
                    <option value="{{ $year }}" {{ old('graduation_year', $member->graduation_year) == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endfor
            </select>
        </div>

        <!-- Pengalaman Kerja -->
        <div class="mb-3">
            <label for="experience" class="form-label">Pengalaman Kerja:</label>
            @php
                $experiences = ['Casting', 'Stamping', 'Decal', 'Operator Produksi', 'Molding', 'Machining', 'Assembling', 'Warehouse', 'Quality Control', 'Admin'];
                $selectedExperience = old('experience', $member->experience);
            @endphp
            <select name="experience" id="experience" class="form-select" style="width: 100%;">
                <option></option>
                @foreach ($experiences as $exp)
                    <option value="{{ $exp }}" {{ $selectedExperience == $exp ? 'selected' : '' }}>{{ $exp }}</option>
                @endforeach
            </select>
            <small class="form-text text-muted">Pilih atau ketik pengalaman kerja Anda.</small>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        function previewPhoto() {
            const file = document.getElementById("photo").files[0];
            const preview = document.getElementById("photo-preview");

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        }

        function previewVaccineCertificate() {
            const file = document.getElementById("vaccine_certificate").files[0];
            const previewContainer = document.getElementById("vaccine-preview-container");
            const placeholder = document.getElementById("vaccine-placeholder");

            if (!file) {
                placeholder.innerHTML = "Belum ada preview.";
                return;
            }

            const fileType = file.type;

            if (fileType.startsWith("image/")) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    placeholder.innerHTML = `<img src="${e.target.result}" class="img-thumbnail" style="max-width:300px;">`;
                };
                reader.readAsDataURL(file);
            } else if (fileType === "application/pdf") {
                const objectURL = URL.createObjectURL(file);
                placeholder.innerHTML = `<embed src="${objectURL}" type="application/pdf" width="100%" height="400px"/>`;
            } else {
                placeholder.innerHTML = "Format tidak didukung.";
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const provinceSelect = document.getElementById('province');
            const regencySelect = document.getElementById('regency');

            function loadRegencies(provinceId, selectedRegencyId = null) {
                regencySelect.innerHTML = '<option value="">-- Pilih Kabupaten/Kota --</option>';
                if (!provinceId) return;

                fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provinceId}.json`)
                    .then(res => res.json())
                    .then(data => {
                        data.forEach(item => {
                            let option = new Option(item.name, item.id);
                            regencySelect.add(option);
                        });
                        if (selectedRegencyId) regencySelect.value = selectedRegencyId;
                    })
                    .catch(() => alert('Gagal memuat kabupaten/kota.'));
            }

            fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')
                .then(res => res.json())
                .then(data => {
                    data.forEach(item => {
                        let option = new Option(item.name, item.id);
                        provinceSelect.add(option);
                    });

                    const oldProvinceId = "{{ old('province_id', $member->province_id) }}";
                    const oldRegencyId = "{{ old('regency_id', $member->regency_id) }}";

                    if (oldProvinceId) {
                        provinceSelect.value = oldProvinceId;
                        loadRegencies(oldProvinceId, oldRegencyId);
                    }
                });

            provinceSelect.addEventListener('change', () => loadRegencies(provinceSelect.value));

            $('#experience').select2({
                placeholder: "Pilih atau ketik pengalaman kerja",
                allowClear: true,
                tags: true,
                width: '100%'
            });

            previewPhoto();
        });
    </script>
</body>
</html>
