<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dynamic CRUD</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Simple Form</h5>
                <p class="card-text">
                <form id="form_submit" action="{{ isset($data) ? url('update', $data->id) : url('create') }}"
                    method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-4">
                            <input type="text" name="name" value="{{ isset($data) ? $data->name : old('name') }}"
                                class="form-control" placeholder="Name">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-4">
                            <input type="email" name="email"
                                value="{{ isset($data) ? $data->email : old('email') }}" class="form-control"
                                placeholder="Email">
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-4">
                            <input type="password" name="password" class="form-control" placeholder="Password">
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <button type="submit"
                        class="btn btn-primary float-right mt-2">{{ isset($data) ? 'Update User' : 'Create User' }}</button>
                </form>
                </p>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-12">
                        <table class="table table-light" id="data_record">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($result))
                                    @forelse ($result as $val)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $val->name }}</td>
                                            <td>{{ $val->email }}</td>
                                            <td>
                                                <a href="{{ url('edit', $val->id) }}">
                                                    <button class="btn btn-primary ">Edit</button>
                                                </a>
                                                <a href="{{ url('delete', $val->id) }}">
                                                    <button class="btn btn-danger">Delete</button>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No Data Available</td>
                                        </tr>
                                    @endforelse
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <a href="{{ route('ajax.index') }}">Using With Ajax</a>
    </div>
</body>



</html>
