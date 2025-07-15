<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kegiatan;

class KegiatanController extends Controller
{
    
    public function index(Request $request)
{
    $query = Kegiatan::query();

    // Filter berdasarkan tanggal jika ada input
    if ($request->has('dari') && $request->has('sampai')) {
        $query->whereBetween('tanggal', [$request->dari, $request->sampai]);
    }

    $kegiatans = $query->orderBy('tanggal', 'desc')->get();

    return view('kegiatans.index', compact('kegiatans'));


        $kegiatans = Kegiatan::all();
        return view('kegiatans.index', compact('kegiatans'));
    }

    public function create()
    {
        return view('kegiatans.create');
    }

    public function store(Request $request)
    {
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
        $kegiatan->user_id   = auth()->id() ?? 1; // default user ID jika belum login
        $kegiatan->save();

        return redirect()->route('kegiatans.index')->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        return view('kegiatans.edit', compact('kegiatan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal'   => 'required|date',
            'status'    => 'required|in:belum,proses,selesai',
        ]);

        $kegiatan = Kegiatan::findOrFail($id);
        $kegiatan->update($request->only(['judul', 'deskripsi', 'tanggal', 'status']));

        return redirect()->route('kegiatans.index')->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        $kegiatan->delete();

        return redirect()->route('kegiatans.index')->with('success', 'Kegiatan berhasil dihapus.');
    }
}
