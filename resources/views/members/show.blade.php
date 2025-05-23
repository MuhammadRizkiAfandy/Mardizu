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
            <div class="row mb-2">
                <div class="col-sm-4 fw-bold">Nama</div>
                <div class="col-sm-8">{{ $member->name }}</div>
            </div>

            <div class="row mb-2">
                <div class="col-sm-4 fw-bold">Jenis Kelamin</div>
                <div class="col-sm-8">{{ $member->gender }}</div>
            </div>

            <div class="row mb-2">
                <div class="col-sm-4 fw-bold">Tempat Lahir</div>
                <div class="col-sm-8">{{ $member->birth_place ?? '-' }}</div>
            </div>

            <div class="row mb-2">
                <div class="col-sm-4 fw-bold">Tanggal Lahir</div>
                <div class="col-sm-8">
                    {{ $member->birth_date ? \Carbon\Carbon::parse($member->birth_date)->format('d-m-Y') : '-' }}
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-sm-4 fw-bold">No KTP</div>
                <div class="col-sm-8">{{ $member->no_ktp }}</div>
            </div>

            <div class="row mb-2">
                <div class="col-sm-4 fw-bold">Tinggi Badan</div>
                <div class="col-sm-8">{{ $member->height ?? '-' }} cm</div>
            </div>

            <div class="row mb-2">
                <div class="col-sm-4 fw-bold">Berat Badan</div>
                <div class="col-sm-8">{{ $member->weight ?? '-' }} kg</div>
            </div>

            <div class="row mb-2">
                <div class="col-sm-4 fw-bold">Telepon</div>
                <div class="col-sm-8">{{ $member->phone ?? '-' }}</div>
            </div>

            <div class="row mb-2">
                <div class="col-sm-4 fw-bold">Email</div>
                <div class="col-sm-8">{{ $member->email }}</div>
            </div>

            <div class="row mb-2">
                <div class="col-sm-4 fw-bold">Provinsi</div>
                <div class="col-sm-8">{{ $member->province ?? '-' }}</div>
            </div>

            <div class="row mb-2">
                <div class="col-sm-4 fw-bold">Kabupaten/Kota</div>
                <div class="col-sm-8">{{ $member->regency ?? '-' }}</div>
            </div>

            <div class="row mb-2">
                <div class="col-sm-4 fw-bold">Tahun Lulus</div>
                <div class="col-sm-8">{{ $member->graduation_year ?? '-' }}</div>
            </div>

            <div class="row mb-2">
                <div class="col-sm-4 fw-bold">Pengalaman Kerja</div>
                <div class="col-sm-8">
                    @if(!empty($member->experience) && is_array($member->experience))
                        {{ implode(', ', $member->experience) }}
                    @elseif(!empty($member->experience))
                        {{ $member->experience }}
                    @else
                        -
                    @endif
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('members.index') }}" class="btn btn-secondary mt-4">← Kembali ke Daftar Member</a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
