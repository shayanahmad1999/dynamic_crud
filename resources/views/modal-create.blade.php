<form id="form_submit" action_url="{{ route('items.store') }}">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title" id="itemModalLabel">Add New Item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="name">Item Name</label>
            <input type="text" class="form-control" name="name" required>
        </div>
        <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" class="form-control" name="quantity" required>
        </div>
        <div class="form-group">
            <label for="user_id">Select User</label>
            <select name="user_id" class="form-control">
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save Item</button>
    </div>
</form>
