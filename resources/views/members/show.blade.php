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
            <div class="row">
                <!-- Foto Member -->
                <div class="col-md-4 text-center mb-4">
                    @if ($member->photo)
                        <img src="{{ asset('storage/' . $member->photo) }}" alt="Foto Member" class="img-thumbnail" style="max-width: 350px;">
                    @else
                        <img src="https://via.placeholder.com/200x250?text=Tidak+Ada+Foto" alt="Tidak Ada Foto" class="img-thumbnail">
                    @endif
                </div>

                <!-- Detail Info -->
                <div class="col-md-8">
                    <div class="row mb-2">
                        <div class="col-sm-4 fw-bold">Nama</div>
                        <div class="col-sm-8">{{ $member->name ?? '-' }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-sm-4 fw-bold">Jenis Kelamin</div>
                        <div class="col-sm-8">{{ $member->gender ?? '-' }}</div>
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
                        <div class="col-sm-8">{{ $member->no_ktp ?? '-' }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-sm-4 fw-bold">Tinggi Badan</div>
                        <div class="col-sm-8">{{ $member->height ? $member->height . ' cm' : '-' }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-sm-4 fw-bold">Berat Badan</div>
                        <div class="col-sm-8">{{ $member->weight ? $member->weight . ' kg' : '-' }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-sm-4 fw-bold">Telepon</div>
                        <div class="col-sm-8">{{ $member->phone ?? '-' }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-sm-4 fw-bold">Email</div>
                        <div class="col-sm-8">{{ $member->email ?? '-' }}</div>
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
                            @if (!empty($member->experience))
                                @if (is_array($member->experience))
                                    {{ implode(', ', $member->experience) }}
                                @else
                                    {{ $member->experience }}
                                @endif
                            @else
                                -
                            @endif
                        </div>
                    </div>

                    <!-- Sertifikat Vaksin -->
                    <div class="row mb-2">
                        <div class="col-sm-4 fw-bold">Sertifikat Vaksin</div>
                        <div class="col-sm-8">
                            @if ($member->vaccine_certificate)
                                <a href="{{ asset('storage/' . $member->vaccine_certificate) }}" target="_blank">Lihat Sertifikat Vaksin</a><br>
                            @else
                                <span>Tidak ada sertifikat vaksin</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </div>

    <a href="{{ route('members.index') }}" class="btn btn-secondary mt-4">← Kembali ke Daftar Member</a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
