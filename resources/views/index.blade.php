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
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Simple Form</h5>
                <p class="card-text">
                <form id="form_submit" action="{{ route('ajax.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="update_key" id="update_key">
                    <div id="error-messages" style="display: none;"></div>
                    <div id="success-message" class="alert alert-success mt-3" style="display:none;"></div>
                    <div class="row">
                        <div class="col-4">
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                class="form-control" placeholder="Name">
                        </div>
                        <div class="col-4">
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                class="form-control" placeholder="Email">
                        </div>
                        <div class="col-4">
                            <input type="password" name="password" class="form-control" placeholder="Password">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary float-right mt-2">Create User</button>
                </form>
                </p>
            </div>
            <div class="card-footer">
                <div class="row mb-3 mt-3">
                    <div class="col-md-4 ml-auto">
                        <input type="search" class="form-control" name="search" placeholder="search...!"
                            id="search" action_url="{{ route('ajax.search') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <table class="table table-light" id="data_record">
                            <thead class="thead-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($result as $val)
                                    <tr>
                                        <td>{{ $val->name }}</td>
                                        <td>{{ $val->email }}</td>
                                        <td>
                                            <button class="btn btn-primary edit"
                                                action_url="{{ route('ajax.edit', $val->id) }}"
                                                data-id="{{ $val->id }}">Edit</button>
                                            <button class="btn btn-danger delete"
                                                action_url="{{ route('ajax.delete', $val->id) }}"
                                                data-id="{{ $val->id }}">Delete</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No Data Available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        @if ($result->hasMorePages())
                            <div class="text-center mt-4" style="margin: auto;">
                                <button class="btn" style="border: 0px;" id="load-more-btn"
                                    data-next-page="{{ $result->nextPageUrl() }}">
                                    Load More
                                </button>
                                <div id="spinner" style="display:none;">Loading...</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/ajax.js') }}"></script>
</body>
</html>
