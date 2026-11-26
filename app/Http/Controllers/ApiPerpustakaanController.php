<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ApiPerpustakaanController extends Controller
{
    public function users(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $data['password'] = Hash::make($data['password']);

        $id = DB::table('users')->insertGetId($data);

        return response()->json([
            'message' => 'User berhasil ditambahkan',
            'id' => $id
        ], 201);
    }
    public function buku(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string',
            'penerbit' => 'required|string',
        ]);

        $id = DB::table('buku')->insertGetId($data);

        return response()->json([
            'message' => 'Buku berhasil ditambahkan',
            'id' => $id
        ], 201);
    }

    // 3. KATEGORI
    public function kategori(Request $request)
    {
        $data = $request->validate([
            'nama_kategori' => 'required|string',
            'deskripsi' => 'required|string',
        ]);

        $id = DB::table('kategori')->insertGetId($data);

        return response()->json([
            'message' => 'Kategori berhasil ditambahkan',
            'id' => $id
        ], 201);
    }

    // 4. LOKASI BUKU
    public function lokasiBuku(Request $request)
    {
        $data = $request->validate([
            'nama_rak' => 'required|string',
            'kode_rak' => 'required|string',
        ]);

        $id = DB::table('lokasi_buku')->insertGetId($data);

        return response()->json([
            'message' => 'Lokasi buku berhasil ditambahkan',
            'id' => $id
        ], 201);
    }

    // 5. ANGGOTA
    public function anggota(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string',
            'alamat' => 'required|string',
        ]);

        $id = DB::table('anggota')->insertGetId($data);

        return response()->json([
            'message' => 'Anggota berhasil ditambahkan',
            'id' => $id
        ], 201);
    }

    // 6. PETUGAS
    public function petugas(Request $request)
    {
        $data = $request->validate([
            'nama_petugas' => 'required|string',
            'no_telp' => 'required|string',
        ]);

        $id = DB::table('petugas')->insertGetId($data);

        return response()->json([
            'message' => 'Petugas berhasil ditambahkan',
            'id' => $id
        ], 201);
    }

    //GET 

    // 1. MENAMPILKAN SEMUA USERS
    public function getUsers()
    {
        return response()->json([
            'message' => 'Data users berhasil ditampilkan',
            'data' => DB::table('users')->select(
                'id',
                'name',
                'email',
                'role',
                'created_at'
            )->get()
        ]);
    }

    // 2. MENAMPILKAN SEMUA BUKU
    public function getBuku()
    {
        return response()->json([
            'message' => 'Data buku berhasil ditampilkan',
            'data' => DB::table('buku')->get()
        ]);
    }

    // 3. MENAMPILKAN SEMUA KATEGORI
    public function getKategori()
    {
        return response()->json([
            'message' => 'Data kategori berhasil ditampilkan',
            'data' => DB::table('kategori')->get()
        ]);
    }

    // 4. MENAMPILKAN SEMUA LOKASI BUKU
    public function getLokasiBuku()
    {
        return response()->json([
            'message' => 'Data lokasi buku berhasil ditampilkan',
            'data' => DB::table('lokasi_buku')->get()
        ]);
    }

    // 5. MENAMPILKAN SEMUA ANGGOTA
    public function getAnggota()
    {
        return response()->json([
            'message' => 'Data anggota berhasil ditampilkan',
            'data' => DB::table('anggota')->get()
        ]);
    }

    // 6. MENAMPILKAN SEMUA PETUGAS
    public function getPetugas()
    {
        return response()->json([
            'message' => 'Data petugas berhasil ditampilkan',
            'data' => DB::table('petugas')->get()
        ]);
    }


    // 1. UPDATE USERS
    public function updateUsers(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string',
            'email' => 'sometimes|required|email|unique:users,email,' . $id,
            'password' => 'sometimes|required|min:6',
            'role' => 'sometimes|required|in:admin,user',
        ]);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user = DB::table('users')->where('id', $id);

        if (!$user->exists()) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }

        $user->update($data);

        return response()->json(['message' => 'User berhasil diubah']);
    }

    // 2. UPDATE BUKU
    public function updateBuku(Request $request, $id)
    {
        $data = $request->validate([
            'judul' => 'sometimes|required|string',
            'penerbit' => 'sometimes|required|string',
        ]);

        $item = DB::table('buku')->where('id', $id);

        if (!$item->exists()) {
            return response()->json(['message' => 'Buku tidak ditemukan'], 404);
        }

        $item->update($data);

        return response()->json(['message' => 'Buku berhasil diubah']);
    }

    // 3. UPDATE KATEGORI
    public function updateKategori(Request $request, $id)
    {
        $data = $request->validate([
            'nama_kategori' => 'sometimes|required|string',
            'deskripsi' => 'sometimes|required|string',
        ]);

        $item = DB::table('kategori')->where('id', $id);

        if (!$item->exists()) {
            return response()->json(['message' => 'Kategori tidak ditemukan'], 404);
        }

        $item->update($data);

        return response()->json(['message' => 'Kategori berhasil diubah']);
    }

    // 4. UPDATE LOKASI BUKU
    public function updateLokasiBuku(Request $request, $id)
    {
        $data = $request->validate([
            'nama_rak' => 'sometimes|required|string',
            'kode_rak' => 'sometimes|required|string',
        ]);

        $item = DB::table('lokasi_buku')->where('id', $id);

        if (!$item->exists()) {
            return response()->json(['message' => 'Lokasi tidak ditemukan'], 404);
        }

        $item->update($data);

        return response()->json(['message' => 'Lokasi buku berhasil diubah']);
    }

    // 5. UPDATE ANGGOTA
    public function updateAnggota(Request $request, $id)
    {
        $data = $request->validate([
            'nama' => 'sometimes|required|string',
            'alamat' => 'sometimes|required|string',
        ]);

        $item = DB::table('anggota')->where('id', $id);

        if (!$item->exists()) {
            return response()->json(['message' => 'Anggota tidak ditemukan'], 404);
        }

        $item->update($data);

        return response()->json(['message' => 'Anggota berhasil diubah']);
    }

    // 6. UPDATE PETUGAS
    public function updatePetugas(Request $request, $id)
    {
        $data = $request->validate([
            'nama_petugas' => 'sometimes|required|string',
            'no_telp' => 'sometimes|required|string',
        ]);

        $item = DB::table('petugas')->where('id', $id);

        if (!$item->exists()) {
            return response()->json(['message' => 'Petugas tidak ditemukan'], 404);
        }

        $item->update($data);

        return response()->json(['message' => 'Petugas berhasil diubah']);
    }


    // 1. DELETE USERS
    public function deleteUsers($id)
    {
        $item = DB::table('users')->where('id', $id);

        if (!$item->exists()) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }

        $item->delete();

        return response()->json(['message' => 'User berhasil dihapus']);
    }

    // 2. DELETE BUKU
    public function deleteBuku($id)
    {
        $item = DB::table('buku')->where('id', $id);

        if (!$item->exists()) {
            return response()->json(['message' => 'Buku tidak ditemukan'], 404);
        }

        $item->delete();

        return response()->json(['message' => 'Buku berhasil dihapus']);
    }

    // 3. DELETE KATEGORI
    public function deleteKategori($id)
    {
        $item = DB::table('kategori')->where('id', $id);

        if (!$item->exists()) {
            return response()->json(['message' => 'Kategori tidak ditemukan'], 404);
        }

        $item->delete();

        return response()->json(['message' => 'Kategori berhasil dihapus']);
    }

    // 4. DELETE LOKASI BUKU
    public function deleteLokasiBuku($id)
    {
        $item = DB::table('lokasi_buku')->where('id', $id);

        if (!$item->exists()) {
            return response()->json(['message' => 'Lokasi tidak ditemukan'], 404);
        }

        $item->delete();

        return response()->json(['message' => 'Lokasi buku berhasil dihapus']);
    }

    // 5. DELETE ANGGOTA
    public function deleteAnggota($id)
    {
        $item = DB::table('anggota')->where('id', $id);

        if (!$item->exists()) {
            return response()->json(['message' => 'Anggota tidak ditemukan'], 404);
        }

        $item->delete();

        return response()->json(['message' => 'Anggota berhasil dihapus']);
    }

    // 6. DELETE PETUGAS
    public function deletePetugas($id)
    {
        $item = DB::table('petugas')->where('id', $id);

        if (!$item->exists()) {
            return response()->json(['message' => 'Petugas tidak ditemukan'], 404);
        }

        $item->delete();

        return response()->json(['message' => 'Petugas berhasil dihapus']);
    }


    // 1. PATCH USERS
    public function patchUsers(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string',
            'email' => 'sometimes|required|email|unique:users,email,' . $id,
            'password' => 'sometimes|required|min:6',
            'role' => 'sometimes|required|in:admin,user',
        ]);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $item = DB::table('users')->where('id', $id);

        if (!$item->exists()) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }

        if (empty($data)) {
            return response()->json(['message' => 'Tidak ada data yang diubah'], 422);
        }

        $item->update($data);

        return response()->json(['message' => 'User berhasil diperbarui']);
    }

    // 2. PATCH BUKU
    public function patchBuku(Request $request, $id)
    {
        $data = $request->validate([
            'judul' => 'sometimes|required|string',
            'penerbit' => 'sometimes|required|string',
        ]);

        $item = DB::table('buku')->where('id', $id);

        if (!$item->exists()) {
            return response()->json(['message' => 'Buku tidak ditemukan'], 404);
        }

        if (empty($data)) {
            return response()->json(['message' => 'Tidak ada data yang diubah'], 422);
        }

        $item->update($data);

        return response()->json(['message' => 'Buku berhasil diperbarui']);
    }

    // 3. PATCH KATEGORI
    public function patchKategori(Request $request, $id)
    {
        $data = $request->validate([
            'nama_kategori' => 'sometimes|required|string',
            'deskripsi' => 'sometimes|required|string',
        ]);

        $item = DB::table('kategori')->where('id', $id);

        if (!$item->exists()) {
            return response()->json(['message' => 'Kategori tidak ditemukan'], 404);
        }

        if (empty($data)) {
            return response()->json(['message' => 'Tidak ada data yang diubah'], 422);
        }

        $item->update($data);

        return response()->json(['message' => 'Kategori berhasil diperbarui']);
    }

    // 4. PATCH LOKASI BUKU
    public function patchLokasiBuku(Request $request, $id)
    {
        $data = $request->validate([
            'nama_rak' => 'sometimes|required|string',
            'kode_rak' => 'sometimes|required|string',
        ]);

        $item = DB::table('lokasi_buku')->where('id', $id);

        if (!$item->exists()) {
            return response()->json(['message' => 'Lokasi tidak ditemukan'], 404);
        }

        if (empty($data)) {
            return response()->json(['message' => 'Tidak ada data yang diubah'], 422);
        }

        $item->update($data);

        return response()->json(['message' => 'Lokasi buku berhasil diperbarui']);
    }

    // 5. PATCH ANGGOTA
    public function patchAnggota(Request $request, $id)
    {
        $data = $request->validate([
            'nama' => 'sometimes|required|string',
            'alamat' => 'sometimes|required|string',
        ]);

        $item = DB::table('anggota')->where('id', $id);

        if (!$item->exists()) {
            return response()->json(['message' => 'Anggota tidak ditemukan'], 404);
        }

        if (empty($data)) {
            return response()->json(['message' => 'Tidak ada data yang diubah'], 422);
        }

        $item->update($data);

        return response()->json(['message' => 'Anggota berhasil diperbarui']);
    }

    // 6. PATCH PETUGAS
    public function patchPetugas(Request $request, $id)
    {
        $data = $request->validate([
            'nama_petugas' => 'sometimes|required|string',
            'no_telp' => 'sometimes|required|string',
        ]);

        $item = DB::table('petugas')->where('id', $id);

        if (!$item->exists()) {
            return response()->json(['message' => 'Petugas tidak ditemukan'], 404);
        }

        if (empty($data)) {
            return response()->json(['message' => 'Tidak ada data yang diubah'], 422);
        }

        $item->update($data);

        return response()->json(['message' => 'Petugas berhasil diperbarui']);
    }
}
