<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon; // jangan lupa import Carbon

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::paginate(10);
        return view('members.index', compact('members'));
    }

    public function create()
    {
        // Menampilkan form tambah member
        return view('members.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'vaccine_certificate' => 'required|file|mimes:pdf|max:2048',
            'name'                => 'required|string|max:255',
            'gender'              => 'required|in:Laki-laki,Perempuan',
            'birth_place'         => 'required|string|max:100',
            'birth_date'          => 'required|date',
            'no_ktp'              => 'required|digits:16|unique:members,no_ktp',
            'height'              => ['required', 'integer', 'min:0'],
            'weight'              => ['required', 'integer', 'min:0'],
            'phone'               => ['required', 'regex:/^[0-9]+$/'],
            'email'               => 'required|email|unique:members,email',
            'photo'               => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'province_id'         => 'required|integer',
            'regency_id'          => 'required|integer',
            'graduation_year'     => 'required|integer|between:2000,2029',
            'experience'          => 'nullable|string|max:255',
        ]);

        try {
            // Ambil nama provinsi dan kabupaten dari API
            $province = Http::timeout(5)->get("https://emsifa.github.io/api-wilayah-indonesia/api/province/{$request->province_id}.json");
            $regency  = Http::timeout(5)->get("https://emsifa.github.io/api-wilayah-indonesia/api/regency/{$request->regency_id}.json");

            if (!$province->successful() || !$regency->successful()) {
                return back()->withErrors(['error' => 'Gagal mengambil data wilayah dari API.'])->withInput();
            }

            $provinceName = $province->json('name');
            $regencyName  = $regency->json('name');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan saat mengakses API wilayah: ' . $e->getMessage()])->withInput();
        }

        // Siapkan data yang akan disimpan
        $data = $validated;
        $data['province']  = $provinceName;
        $data['regency']   = $regencyName;
        $data['experience'] = $request->experience;

        // Simpan file foto
        // Baru
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $data['photo'] = $path;
        }

        // Simpan file sertifikat vaksin
        if ($request->hasFile('vaccine_certificate')) {
            $path = $request->file('vaccine_certificate')->store('vaccine_certificates', 'public');
            $data['vaccine_certificate'] = $path;
        }

        // Simpan data member ke database
        Member::create($data);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('members.index')->with('success', 'Member berhasil ditambahkan');
    }


    public function show($id)
    {
        $member = Member::findOrFail($id);
        return view('members.show', compact('member'));
    }

    public function edit(Member $member)
    {
        // Parsing birth_date ke Carbon jika ada, agar bisa dipanggil format() di Blade
        if ($member->birth_date) {
            $member->birth_date = Carbon::parse($member->birth_date);
        }

        return view('members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'vaccine_certificate' => 'required|file|mimes:pdf|max:2048',
            'name'            => 'required|string|max:255',
            'gender'          => 'required|in:Laki-laki,Perempuan',
            'birth_place'     => 'required|string|max:100',
            'birth_date'      => 'required|date',
            'no_ktp'          => 'required|digits:16|unique:members,no_ktp,' . $member->id,
            'height'          => ['required', 'integer', 'min:0'],
            'weight'          => ['required', 'integer', 'min:0'],
            'phone'           => ['required', 'regex:/^[0-9]+$/'],
            'email'           => 'required|email|unique:members,email,' . $member->id,
            'photo'           => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'province_id'     => 'required|integer',
            'regency_id'      => 'required|integer',
            'graduation_year' => 'required|integer|between:2000,2029',
            'experience'      => 'nullable|string|max:255',
        ]);

        try {
            $province = Http::timeout(5)->get("https://emsifa.github.io/api-wilayah-indonesia/api/province/{$request->province_id}.json");
            $regency  = Http::timeout(5)->get("https://emsifa.github.io/api-wilayah-indonesia/api/regency/{$request->regency_id}.json");

            if (!$province->successful() || !$regency->successful()) {
                return back()->withErrors(['error' => 'Gagal mengambil data wilayah dari API.'])->withInput();
            }

            $provinceName = $province->json('name');
            $regencyName  = $regency->json('name');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan saat mengakses API wilayah: ' . $e->getMessage()])->withInput();
        }

        $data = $validated;
        $data['province'] = $provinceName;
        $data['regency'] = $regencyName;
        $data['experience'] = $request->experience;
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $data['photo'] = $path;
        }

        if ($request->hasFile('vaccine_certificate')) {
            $path = $request->file('vaccine_certificate')->store('vaccine_certificates', 'public');
            $member->vaccine_certificate = $path;
        }

        $member->update($data);

        return redirect()->route('members.index')->with('success', 'Member berhasil diupdate');
    }
    public function destroy(Member $member)
    {
        try {
            $member->delete();
            return redirect()->route('members.index')->with('success', 'Member berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('members.index')->withErrors(['error' => 'Gagal menghapus member: ' . $e->getMessage()]);
        }
    }
}
