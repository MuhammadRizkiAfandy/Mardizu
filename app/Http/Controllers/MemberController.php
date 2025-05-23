<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data member
        $members = Member::all();
        return view('members.index', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Tampilkan form tambah member baru
        return view('members.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',         
            'gender'       => 'required|in:Laki-laki,Perempuan',
            'birth_place'  => 'nullable|string|max:100',
            'birth_date'   => 'nullable|date',
            'no_ktp'       => ['required', 'digits:16'],
            'height'       => ['nullable', 'integer', 'min:0'],
            'weight'       => ['nullable', 'integer', 'min:0'],
            'phone'        => ['nullable', 'regex:/^[0-9]+$/'],
            'email'        => 'required|email|unique:members,email',
            'province_id'  => 'required',
            'regency_id'   => 'required',
        ]);

        // Ambil nama provinsi dan kabupaten dari API
        $provinceData = @file_get_contents("https://emsifa.github.io/api-wilayah-indonesia/api/province/{$request->province_id}.json");
        $regencyData  = @file_get_contents("https://emsifa.github.io/api-wilayah-indonesia/api/regency/{$request->regency_id}.json");

        $provinceName = optional(json_decode($provinceData))->name;
        $regencyName  = optional(json_decode($regencyData))->name;

        // Simpan data
        Member::create([
            'name'        => $request->name,
            'gender'      => $request->gender,
            'birth_place' => $request->birth_place,
            'birth_date'  => $request->birth_date,
            'no_ktp'      => $request->no_ktp,
            'height'      => $request->height,
            'weight'      => $request->weight,
            'phone'       => $request->phone,
            'email'       => $request->email,
            'province'    => $provinceName,
            'regency'     => $regencyName,
        ]);

        return redirect()->route('members.index')->with('success', 'Member berhasil ditambahkan');
    }



    /**
     * Display the specified resource.
     * (Opsional, jika tidak digunakan bisa dihapus atau dikosongkan)
     */
    public function show(Member $member)
    {
        // Bisa tampilkan detail member jika perlu
        return view('members.show', compact('member'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        // Tampilkan form edit member dengan data member yang dipilih
        return view('members.edit', compact('member'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:members,email,' . $member->id,
            'phone'       => ['nullable', 'regex:/^[0-9]+$/'],
            'gender'      => 'required|in:Laki-laki,Perempuan',
            'province_id' => 'required',
            'regency_id'  => 'required',
        ]);

        // Ambil nama provinsi dan kabupaten
        $provinceData = @file_get_contents("https://emsifa.github.io/api-wilayah-indonesia/api/province/{$request->province_id}.json");
        $regencyData  = @file_get_contents("https://emsifa.github.io/api-wilayah-indonesia/api/regency/{$request->regency_id}.json");

        $provinceName = optional(json_decode($provinceData))->name;
        $regencyName  = optional(json_decode($regencyData))->name;

        // Update data
        $member->update([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'gender'   => $request->gender,
            'province' => $provinceName,
            'regency'  => $regencyName,
        ]);

        return redirect()->route('members.index')->with('success', 'Member berhasil diupdate');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        // Hapus member
        $member->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('members.index')->with('success', 'Member berhasil dihapus');
    }
}
