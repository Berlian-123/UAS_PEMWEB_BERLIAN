<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Kegiatan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Rute-rute untuk aplikasi manajemen kegiatan
|
*/

// Tampilkan semua kegiatan
Route::get('/kegiatans', function () {
    $kegiatans = Kegiatan::all();
    return view('kegiatans.index', compact('kegiatans'));
})->name('kegiatans.index');

// Form tambah kegiatan
Route::get('/kegiatans/create', function () {
    return view('kegiatans.create');
})->name('kegiatans.create');

// Simpan kegiatan baru
Route::post('/kegiatans', function (Request $request) {
    $request->validate([
        'judul'     => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
        'tanggal'   => 'required|date',
        'status'    => 'required|in:belum,proses,selesai',
    ]);

    $kegiatan = new Kegiatan;
    $kegiatan->judul     = $request->judul;
    $kegiatan->deskripsi = $request->deskripsi;
    $kegiatan->tanggal   = $request->tanggal;
    $kegiatan->status    = $request->status;
    $kegiatan->user_id   = auth()->id() ?? 1; // fallback user_id
    $kegiatan->save();

    return redirect()->route('kegiatans.index')->with('success', 'Kegiatan berhasil ditambahkan.');
})->name('kegiatans.store');

// Form edit kegiatan
Route::get('/kegiatans/{id}/edit', function ($id) {
    $kegiatan = Kegiatan::findOrFail($id);
    return view('kegiatans.edit', compact('kegiatan'));
})->name('kegiatans.edit');

// Simpan perubahan kegiatan
Route::put('/kegiatans/{id}', function (Request $request, $id) {
    $request->validate([
        'judul'     => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
        'tanggal'   => 'required|date',
        'status'    => 'required|in:belum,proses,selesai',
    ]);

    $kegiatan = Kegiatan::findOrFail($id);
    $kegiatan->update($request->only(['judul', 'deskripsi', 'tanggal', 'status']));

    return redirect()->route('kegiatans.index')->with('success', 'Kegiatan berhasil diperbarui.');
})->name('kegiatans.update');

// Hapus kegiatan
Route::delete('/kegiatans/{id}', function ($id) {
    $kegiatan = Kegiatan::findOrFail($id);
    $kegiatan->delete();

    return redirect()->route('kegiatans.index')->with('success', 'Kegiatan berhasil dihapus.');
})->name('kegiatans.destroy');


Route::get('kegiatans', 'KegiatanController@index')->name('kegiatans.index');
Route::get('kegiatans/create', 'KegiatanController@create')->name('kegiatans.create');
Route::post('kegiatans', 'KegiatanController@store')->name('kegiatans.store');
Route::get('kegiatans/{id}/edit', 'KegiatanController@edit')->name('kegiatans.edit');
Route::put('kegiatans/{id}', 'KegiatanController@update')->name('kegiatans.update');
Route::delete('kegiatans/{id}', 'KegiatanController@destroy')->name('kegiatans.destroy');

use App\User;

Route::get('/user-profile/{user_id}', function ($id) {
    $user = User::with('profile')->find($id);

    if (!$user) {
        return "User tidak ditemukan.";
    }

    echo "Nama: " . $user->name . "<br>";
    echo "Alamat: " . ($user->profile->alamat ?? 'Belum ada profil');
});

use App\Catatan;

Route::get('/catatan', function () {
    $catatans = Catatan::with('user', 'kegiatan')->get();

    foreach ($catatans as $catatan) {
        echo "Judul: {$catatan->judul} <br>";
        echo "Isi: {$catatan->isi} <br>";
        echo "Tanggal: {$catatan->tanggal} <br>";
        echo "User: " . ($catatan->user->name ?? 'N/A') . "<br>";
        echo "Kegiatan: " . ($catatan->kegiatan->judul ?? 'N/A') . "<br><hr>";
    }
});


Route::get('/catatan/{id}', function ($id) {
    $catatan = Catatan::with('user', 'kegiatan')->findOrFail($id);

    echo "Judul: {$catatan->judul} <br>";
    echo "Isi: {$catatan->isi} <br>";
    echo "Tanggal: {$catatan->tanggal} <br>";
    echo "User: " . ($catatan->user->name ?? 'N/A') . "<br>";
    echo "Kegiatan: " . ($catatan->kegiatan->judul ?? 'N/A') . "<br>";
});


Route::get('/kegiatan-catatan/{id}', function ($id) {
    $kegiatan = Kegiatan::with('catatans.user')->findOrFail($id);

    echo "<h3>Kegiatan: {$kegiatan->judul}</h3><br>";
    echo "<strong>Daftar Catatan:</strong><br>";

    foreach ($kegiatan->catatans as $catatan) {
        echo "- {$catatan->judul} oleh " . ($catatan->user->name ?? 'N/A') . "<br>";
    }
});
