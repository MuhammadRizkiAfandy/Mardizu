<!DOCTYPE html>
<html>
<head>
    <title>Edit Member</title>
</head>
<body>
    <h1>Edit Member</h1>

    <a href="{{ route('members.index') }}">Kembali ke Daftar Member</a>

    @if ($errors->any())
        <div style="color: red;">
            <strong>Oops! Ada masalah dengan input:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('members.update', $member->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label>Nama:</label><br>
            <input type="text" name="name" value="{{ old('name', $member->name) }}" required>
        </div>

        <div>
            <label>Email:</label><br>
            <input type="email" name="email" value="{{ old('email', $member->email) }}" required>
        </div>

        <div>
            <label>Telepon:</label><br>
            <input type="text" name="phone" value="{{ old('phone', $member->phone) }}">
        </div>

        <br>
        <button type="submit">Update</button>
    </form>
</body>
</html>
