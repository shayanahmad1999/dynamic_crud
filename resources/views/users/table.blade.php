<table class="table table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                <button class="btn btn-primary edit" action_url="{{ route('users.edit', $user->id) }}" data-id="{{ $user->id }}">Edit</button>
                <button class="btn btn-danger delete" action_url="{{ route('users.destroy', $user->id) }}" data-id="{{ $user->id }}">Delete</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $users->links() }}
