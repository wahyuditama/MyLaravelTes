<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Books;

class Bookcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $book = Books::all();

        return response()->json($book);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'string',
            'max:255',
            'penulis' => 'required',
            'string',
            'max:255',
            'penerbit' => 'required',
            'string',
            'max:255',
            'gambar' => 'nullable|image|mimes:jpg,png,jpg,gif|max:2048',
            'tahun_terbit' => 'required|integer',
        ]);

        $data = $request->except('gambar');

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            $data['gambar'] = 'uploads/' . $filename;
        }

        $book = Books::create($data);
        return response()->json($book, status: 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Books::find($id);
        if (!$book) {
            return response()->json(['status' => 404, 'message' => 'book Tidak Ditemukan']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $book = Books::find($id);
        if (!$book) {
            return response()->json([
                'status' => 'error',
                'message' => 'bok$book Tidak Ditemukan'
            ],  400);
        }

        $request->validate([
            'judul' => 'string|max:255',
            'penulis' => 'string|max:255',
            'penerbit' => 'string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tahun _terbit' => 'integer',
        ]);

        $data = $request->except('gambar');

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);

            if ($book->gambar) {
                $oldImagePath = public_path($book->gambar);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $data['gambar'] = 'uploads/' . $filename;
        }

        $book->update($data);
        return response()->json([
            'status' => 'success',
            'message' => 'Buku Berhasil Diubah',
            'data' => $book
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Books::find($id);
        if (!$book) {
            return response()->json(['message' => 'Buku Telah Dihapus'], 400);
        }

        $book->delete();
        return response(['message' => 'Buku berhasil dihapus'], 200);
    }
}
