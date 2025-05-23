<!DOCTYPE html>
<html>
<head>
    <title>Detail Member</title>
</head>
<body>
    <h1>Detail Member</h1>

    <a href="{{ route('members.index') }}">Kembali ke Daftar Member</a>

    <table border="1" cellpadding="5" cellspacing="0" style="margin-top: 10px;">
        <tr>
            <th>ID</th>
            <td>{{ $member->id }}</td>
        </tr>
        <tr>
            <th>Nama</th>
            <td>{{ $member->name }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $member->email }}</td>
        </tr>
        <tr>
            <th>Telepon</th>
            <td>{{ $member->phone ?? '-' }}</td>
        </tr>
        <tr>
            <th>Dibuat pada</th>
            <td>{{ $member->created_at->format('d M Y H:i') }}</td>
        </tr>
        <tr>
            <th>Diupdate pada</th>
            <td>{{ $member->updated_at->format('d M Y H:i') }}</td>
        </tr>
    </table>
</body>
</html>
