<!DOCTYPE html>
<html>
<head>
    <title>LP3M</title>
</head>
<body>

<h1>Data Profil LP3M</h1>

@foreach($profil as $p)
    <h3>{{ $p->judul }}</h3>
    <div>{!! $p->isi_konten !!}</div>
    <hr>
@endforeach

</body>
</html>