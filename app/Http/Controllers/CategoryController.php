<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Throwable;

class CategoryController extends Controller
{
    use ApiResponse;

    // GET /api/categories  (dengan jumlah transaksi per kategori)
    public function index()
    {
        try {
            $data = Category::withCount('transactions')->get();
            return $this->success($data, 'Daftar kategori');
        } catch (Throwable $e) {
            Log::error('Gagal mengambil kategori: ' . $e->getMessage());
            return $this->error('Terjadi kesalahan pada server', 500);
        }
    }

    public function show(string $id)
    {
        try {
            $data = Category::withCount('transactions')->findOrFail($id);
            return $this->success($data, 'Detail kategori');
        } catch (ModelNotFoundException $e) {
            return $this->error('Kategori tidak ditemukan', 404);
        } catch (Throwable $e) {
            Log::error('Gagal mengambil kategori: ' . $e->getMessage());
            return $this->error('Terjadi kesalahan pada server', 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama' => 'required|string|max:50|unique:categories,nama',
            ]);
            $category = Category::create($validated);

            return $this->success($category, 'Kategori dibuat', 201);
        } catch (ValidationException $e) {
            return $this->error('Validasi gagal', 422, $e->errors());
        } catch (Throwable $e) {
            Log::error('Gagal menyimpan kategori: ' . $e->getMessage());
            return $this->error('Terjadi kesalahan pada server', 500);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $category = Category::findOrFail($id);
            $validated = $request->validate([
                'nama' => [
                    'required', 'string', 'max:50',
                    Rule::unique('categories', 'nama')->ignore($category->id),
                ],
            ]);
            $category->update($validated);

            return $this->success($category, 'Kategori diperbarui');
        } catch (ModelNotFoundException $e) {
            return $this->error('Kategori tidak ditemukan', 404);
        } catch (ValidationException $e) {
            return $this->error('Validasi gagal', 422, $e->errors());
        } catch (Throwable $e) {
            Log::error('Gagal memperbarui kategori: ' . $e->getMessage());
            return $this->error('Terjadi kesalahan pada server', 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            Category::findOrFail($id)->delete();
            return $this->success(null, 'Kategori dihapus');
        } catch (ModelNotFoundException $e) {
            return $this->error('Kategori tidak ditemukan', 404);
        } catch (Throwable $e) {
            Log::error('Gagal menghapus kategori: ' . $e->getMessage());
            return $this->error('Terjadi kesalahan pada server', 500);
        }
    }
}