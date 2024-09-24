@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-8">
                <h1>Item List</h1>
            </div>

            <div class="col-md-4">
                <a href="javascript:void(0)" id="add_data" action_url="{{ route('items.create') }}" class="btn btn-success">Add
                    New
                    Item</a>
            </div>
        </div>

        <div class="mb-3">
            <input type="text" id="search" action_url="{{ route('items.search') }}" class="form-control"
                placeholder="Search items...">
        </div>

        <div id="record_table">
            @include('modal-table')
        </div>

    </div>

    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="itemModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
               
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('assets/ajax-modal.js') }}"></script>
    @endpush
@endsection
