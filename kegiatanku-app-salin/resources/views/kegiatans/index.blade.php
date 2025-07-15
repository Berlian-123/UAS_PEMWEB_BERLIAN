<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kegiatan</title>

    <!-- Bootstrap 3 CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>

<div class="container" style="margin-top: 30px;">

    <h2 class="text-center">📋 Daftar Kegiatan</h2>

    {{-- Alert sukses --}}
    @if (session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    <div class="text-right" style="margin-bottom: 15px;">
        <a href="{{ route('kegiatans.create') }}" class="btn btn-primary">
            <i class="glyphicon glyphicon-plus"></i> Tambah Kegiatan
        </a>
    </div>

    <div class="row">
    <form action="{{ route('kegiatans.index') }}" method="GET" class="form-inline text-center" style="margin-bottom: 20px;">
        <div class="form-group">
            <label for="dari">Dari: </label>
            <input type="date" name="dari" id="dari" class="form-control" value="{{ request('dari') }}">
        </div>
        <div class="form-group">
            <label for="sampai">Sampai: </label>
            <input type="date" name="sampai" id="sampai" class="form-control" value="{{ request('sampai') }}">
        </div>
        <button type="submit" class="btn btn-info">
            <i class="glyphicon glyphicon-search"></i> Filter
        </button>
        <a href="{{ route('kegiatans.index') }}" class="btn btn-default">
            <i class="glyphicon glyphicon-refresh"></i> Reset
        </a>
    </form>
</div>


    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr class="info text-center">
                <th style="width: 50px;">No</th>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th style="width: 120px;">Tanggal</th>
                <th style="width: 100px;">Status</th>
                <th style="width: 130px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kegiatans as $kegiatan)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $kegiatan->judul }}</td>
                    <td>{{ $kegiatan->deskripsi }}</td>
                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('d-m-Y') }}
                    </td>
                    <td class="text-center">
                        <span class="label label-{{ 
                            $kegiatan->status == 'belum' ? 'default' : 
                            ($kegiatan->status == 'proses' ? 'warning' : 'success') 
                        }}">
                            {{ ucfirst($kegiatan->status) }}
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('kegiatans.edit', $kegiatan->id) }}" class="btn btn-xs btn-warning">
                            <i class="glyphicon glyphicon-edit"></i> Edit
                        </a>
                        <form action="{{ route('kegiatans.destroy', $kegiatan->id) }}" method="POST" style="display:inline;">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Yakin ingin menghapus kegiatan ini?')">
                                <i class="glyphicon glyphicon-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Tidak ada data kegiatan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

</body>
</html>
