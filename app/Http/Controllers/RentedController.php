<?php

namespace App\Http\Controllers;

use App\Models\Rented;
use App\Models\Books;
use App\Models\Members;

use Illuminate\Http\Request;

class RentedController extends Controller
{
    public function index()
    {
        $rented = Rented::with(['member', 'book'])->get();
        return response()->json([
            'status' => 'Berhasil',
            'message' => "Data penyewaan berhasil dimuat",
            'data' => $rented
        ], 200);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'member_id' => 'required|exists:members,id',
                'book_id' => 'required|exists:books,id',
                'tanggal_pinjam' => 'required|date'
            ]);

            $renRented = Rented::create([
                'member_id' => $request->member_id,
                'book_id' => $request->book_id,
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'status' => 'dipinjam'
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Buku berhasil dipinjam',
                'data' => $renRented
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $rented = Rented::findOrFail($id);
        if (!$rented) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $rented->update([
            'tanggal_kembali' => now(),
            'status' => 'dikembalikan'
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Buku telah dikembalikan',
            'data' => $rented
        ], 200);
    }

    public function destroy($id)
    {
        $rented = Rented::find($id);
        if (!$rented) {
            return response()->json(['message' => 'Data rented tidak ditemukan'], 404);
        }

        $rented->delete();

        return response()->json(['message' => 'Data rented berhasil dihapus'], 200);
    }
}
