<form id="form_edit" action_url="{{ route('items.update', $item->id) }}">
    @csrf
    @method('PUT')
    <div class="modal-header">
        <h5 class="modal-title" id="itemModalLabel">Edit Item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="name">Item Name</label>
            <input type="text" class="form-control" name="name" value="{{ $item->name }}" required>
        </div>
        <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" class="form-control" name="quantity" value="{{ $item->quantity }}" required>
        </div>
        <div class="form-group">
            <label for="user_id">Select User</label>
            <select name="user_id" class="form-control">
                @foreach($users as $user)
                <option value="{{ $user->id }}" {{ $item->user_id == $user->id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update Item</button>
    </div>
</form>

