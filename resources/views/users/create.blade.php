<form id="submit_form" action_url="{{ route('users.store') }}">
    @csrf
    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" class="form-control" id="name" value="{{ isset($user) ? $user->name : old('name') }}"
            name="name" required>
    </div>
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email"
            value="{{ isset($user) ? $user->email : old('email') }}" name="email" required>
    </div>
    <input type="hidden" name="update_key" value="{{ isset($user) ? $user->id : '' }}" id="update_key">
    <button type="submit" class="btn btn-primary">{{ isset($user) ? 'Update' : 'Save' }}</button>
</form>
