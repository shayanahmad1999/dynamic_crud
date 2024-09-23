@forelse ($result as $val)
    <tr>
        <td>{{ $val->name }}</td>
        <td>{{ $val->email }}</td>
        <td>
            <button class="btn btn-primary edit" action_url="{{ route('ajax.edit', $val->id) }}"
                data-id="{{ $val->id }}">Edit</button>
            <button class="btn btn-danger delete" action_url="{{ route('ajax.delete', $val->id) }}"
                data-id="{{ $val->id }}">Delete</button>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="4" class="text-center">No Data Available</td>
    </tr>
@endforelse
