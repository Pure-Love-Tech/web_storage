@php
    $users = \App\Models\User::all();
@endphp
<select name="user" class="form-select selectpicker" title="{{ admin_trans('User') }}" data-live-search="true">
    @foreach ($users as $user)
        <option value="{{ $user->id }}" {{ request('user') == $user->id ? 'selected' : '' }}>
            {{ $user->id . ' - ' . $user->username . ' (' . $user->email . ')' }}
        </option>
    @endforeach
</select>
