<?php

namespace App\Http\Controllers;

use App\Models\Members;

use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $member = Members::all();
        return response()->json([
            'status' => 'success',
            'message' => 'Daftar member berhasil diambil',
            'data' => $member
        ], 200);
    }

    // Menambah member baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:members',
            'alamat' => 'required|string',
            'telepon' => 'required|string'
        ]);

        $member = Members::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'member berhasil ditambahkan',
            'data' => $member
        ], 201);
    }

    // Menampilkan satu member
    public function show($id)
    {
        $member = Members::find($id);
        if (!$member) {
            return response()->json(['message' => 'member tidak ditemukan'], 404);
        }

        return response()->json($member);
    }

    // Mengupdate data member
    public function update(Request $request, $id)
    {
        $member = Members::find($id);
        if (!$member) {
            return response()->json(['message' => 'member tidak ditemukan'], 404);
        }

        $request->validate([
            'nama' => 'string|max:255',
            'email' => 'email|unique:members,email,' . $member->id,
            'alamat' => 'string',
            'telepon' => 'string'
        ]);

        $member->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Data member berhasil diperbarui',
            'data' => $member
        ], 200);
    }

    // Menghapus member
    public function destroy($id)
    {
        $member = Members::find($id);
        if (!$member) {
            return response()->json(['message' => 'member tidak ditemukan'], 404);
        }

        $member->delete();

        return response()->json(['message' => 'member berhasil dihapus'], 200);
    }
}
