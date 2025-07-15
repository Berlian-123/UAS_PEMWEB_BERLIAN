<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Kegiatan; // Pastikan ini benar untuk Laravel 5.5
use App\Http\Resources\KegiatanResource;
use App\Http\Resources\KegiatanCollection;
use Illuminate\Support\Facades\Log; // <<< Pastikan ini ada

class ApiKegiatanController extends Controller
{
    // GET /api/kegiatans
    public function index()
    {
        try {
            // Tambahkan log ini untuk memastikan metode ini dipanggil
            Log::info('ApiKegiatanController@index: Memulai pengambilan data kegiatan.');

            // Baris ini adalah sumber error 500 yang paling mungkin
            $kegiatans = Kegiatan::all();

            // Tambahkan log ini untuk memastikan data berhasil diambil
            Log::info('ApiKegiatanController@index: Data kegiatan berhasil diambil.', ['count' => $kegiatans->count()]);

            return new KegiatanCollection($kegiatans);

        } catch (\Exception $e) {
            // Ini adalah bagian TERPENTING untuk debugging
            Log::error('ApiKegiatanController@index: Terjadi error saat mengambil data kegiatan!', [
                'message' => $e->getMessage(), // Pesan error utama
                'file' => $e->getFile(),       // File tempat error terjadi
                'line' => $e->getLine(),       // Baris kode tempat error terjadi
                'trace' => $e->getTraceAsString(), // Full stack trace
            ]);
            return response()->json(['error' => 'Gagal mengambil data kegiatan. Silakan periksa log server untuk detail.'], 500);
        }
    }

    // ... (metode show, store, update, destroy tetap sama)

    // GET /api/kegiatans/{id}
    public function show($id)
    {
        $kegiatan = Kegiatan::find($id);
        if (!$kegiatan) {
            return response()->json(['message' => 'Kegiatan tidak ditemukan'], 404);
        }
        return new KegiatanResource($kegiatan);
    }

    // POST /api/kegiatans
    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal'   => 'required|date',
            'status'    => 'required|in:belum,proses,selesai',
        ]);

        $data['user_id'] = auth()->id() ?? 1; // default user

        $kegiatan = Kegiatan::create($data);

        return new KegiatanResource($kegiatan);
    }

    // PUT /api/kegiatans/{id}
    public function update(Request $request, $id)
    {
        $kegiatan = Kegiatan::find($id);
        if (!$kegiatan) {
            return response()->json(['message' => 'Kegiatan tidak ditemukan'], 404);
        }

        $data = $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal'   => 'required|date',
            'status'    => 'required|in:belum,proses,selesai',
        ]);

        $kegiatan->update($data);

        return new KegiatanResource($kegiatan);
    }

    // DELETE /api/kegiatans/{id}
    public function destroy($id)
    {
        $kegiatan = Kegiatan::find($id);
        if (!$kegiatan) {
            return response()->json(['message' => 'Kegiatan tidak ditemukan'], 404);
        }

        $kegiatan->delete();

        return response()->json(['message' => 'Kegiatan berhasil dihapus']);
    }
}

