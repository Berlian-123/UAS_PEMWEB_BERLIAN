<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use App\Kegiatan;
use App\User;

class KegiatanFeatureTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function dapat_melihat_halaman_daftar_kegiatan()
    {
        $kegiatan = factory(Kegiatan::class)->create([
            'judul' => 'Belajar Laravel',
        ]);

        $this->get('/kegiatans')
             ->assertStatus(200)
             ->assertSee('Belajar Laravel');
    }

    /** @test */
    public function dapat_menambah_kegiatan_baru()
    {
        // Buat user dummy
        $user = factory(User::class)->create();

        // Login user
        $this->actingAs($user);

        // Data kegiatan baru
        $data = [
            'judul' => 'Kegiatan Baru',
            'deskripsi' => 'Deskripsi testing',
            'tanggal' => '2025-07-09',
            'status' => 'proses',
            // 'user_id' tidak perlu karena diambil dari auth()->id()
        ];

        $this->post('/kegiatans', $data)
             ->assertRedirect('/kegiatans');

        $this->assertDatabaseHas('kegiatans', [
            'judul' => 'Kegiatan Baru',
            'user_id' => $user->id
        ]);
    }
}
