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
        // Validasi input
        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:members,email',
            'phone'  => 'nullable|string|max:20',
            'gender' => 'required|in:Laki-laki,Perempuan',
        ]);

        // Simpan data member baru
        Member::create($request->all());

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
        // Validasi input update
        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:members,email,' . $member->id,
            'phone' => ['nullable', 'regex:/^[0-9]+$/'],
            'gender' => 'required|in:Laki-laki,Perempuan',
        ]);

        // Update data member
        $member->update($request->all());

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
