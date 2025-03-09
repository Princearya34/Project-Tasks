@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('users.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Name:</label>
        <input type="text" name="name" class="form-control" value="{{ old('name') }}">
    </div>
    <div class="mb-3">
        <label>Email:</label>
        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
    </div>
    <div class="mb-3">
        <label>Password:</label>
        <input type="password" name="password" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
