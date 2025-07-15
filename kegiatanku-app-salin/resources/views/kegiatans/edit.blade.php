<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kegiatan</title>

    <!-- Bootstrap 3 CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h2 class="text-center" style="margin-top: 30px;">Edit Kegiatan</h2>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            {{-- Notifikasi sukses (jika pakai redirect dengan session) --}}
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Tampilkan error validasi --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Ups!</strong> Ada kesalahan saat input data:<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('kegiatans.update', $kegiatan->id) }}" method="POST" autocomplete="off">
                {{ csrf_field() }}
                {{ method_field('PUT') }}

                <div class="form-group">
                    <label for="judul">Judul Kegiatan</label>
                    <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul', $kegiatan->judul) }}" required>
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required>{{ old('deskripsi', $kegiatan->deskripsi) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ old('tanggal', $kegiatan->tanggal) }}" required>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="belum" {{ old('status', $kegiatan->status) == 'belum' ? 'selected' : '' }}>Belum</option>
                        <option value="proses" {{ old('status', $kegiatan->status) == 'proses' ? 'selected' : '' }}>Proses</option>
                        <option value="selesai" {{ old('status', $kegiatan->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-warning">
                    <i class="glyphicon glyphicon-save"></i> Update
                </button>
                <a href="{{ route('kegiatans.index') }}" class="btn btn-default">
                    <i class="glyphicon glyphicon-chevron-left"></i> Batal
                </a>
            </form>

        </div>
    </div>
</div>

</body>
</html>
