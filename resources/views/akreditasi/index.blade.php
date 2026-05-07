<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Akreditasi - LP3M Politeknik Jambi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Daftar Akreditasi Program Studi</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Program Studi</th>
                        <th>Strata</th>
                        <th>Status Akreditasi</th>
                        <th>Lembaga</th>
                        <th>Masa Berlaku</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $key => $item)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item->nama_prodi }}</td>
                        <td>{{ $item->strata }}</td>
                        <td>
                            <span class="badge bg-success">{{ $item->status }}</span>
                        </td>
                        <td>{{ $item->lembaga }}</td>
                        <td>{{ $item->tanggal_kadaluarsa }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Data tidak ditemukan di database.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>