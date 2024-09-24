<table class="table table-bordered">
    <thead>
        <tr>
            <th>Item Name</th>
            <th>Quantity</th>
            <th>User</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $item)
        <tr>
            <td>{{ $item->name }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ $item->user->name }}</td>
            <td>
                <a href="javascript:void(0)" class="btn btn-warning edit" action_url="{{ route('items.edit', $item->id) }}" data-id="{{ $item->id }}">Edit</a>
                <a href="javascript:void(0)" class="btn btn-danger delete" action_url="{{ route('items.destroy', $item->id) }}" data-id="{{ $item->id }}">Delete</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $items->links() }}
