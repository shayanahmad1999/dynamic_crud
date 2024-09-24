@extends('layouts.app2')

@section('content')
    <div class="container">
        <div class="row mt-3">
            <div class="col-md-8">
                <h2 class="title">User List</h2>
            </div>
            <div class="col-md-4"><button class="btn btn-primary" id="add" action_url="{{ route('users.create') }}">Add
                    New User</button></div>
        </div>
        <div id="container">
            <div class="mb-3">
                <input type="text" id="search" action_url="{{ route('users.index') }}" class="form-control"
                    placeholder="Search Users">
            </div>
            <div id="record_data">
                @include('users.table', ['users' => $users])
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{asset('assets/separate-ajax.js')}}"></script>
    @endpush
@endsection
