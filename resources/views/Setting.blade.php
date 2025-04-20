@php
    $activePage = 'setting'; // or 'inventory', 'dashboard', etc.
@endphp
@extends('layouts.app')

@section('content')
    <!-- Settings Section -->
    <section id="settings" class=""
        style="width: -webkit-fill-available;background: #fff;padding: 25px;border-radius: 10px;margin: 1px 13px 37px 11px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);">
        <div class="state-header">
            <h3>System Settings</h3>
            <div class="actions">
                <button class="btn">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </div>
        </div>

        <!-- Settings Categories -->
        <div class="settings-container">
            <div class="settings-sidebar">
                <ul class="settings-menu">
                    <li class="active" data-settings="account"><i class="fas fa-user-circle"></i> Account
                        Settings</li>
                    <li data-settings="notifications"><i class="fas fa-bell"></i> Notifications</li>
                    <li data-settings="security"><i class="fas fa-shield-alt"></i> Security</li>
                    <li data-settings="appearance"><i class="fas fa-paint-brush"></i> Appearance</li>
                    <li data-settings="users"><i class="fas fa-users-cog"></i> User Management</li>
                    <li data-settings="system"><i class="fas fa-cogs"></i> System Settings</li>
                </ul>
            </div>

            <div class="settings-content">
                <div class="settings-panel active" id="account-settings">
                    <h4>Account Settings</h4>
                    <form method="POST" action="{{ route('settings.update') }}">
                        @csrf
                        {{-- If your route expects PUT or PATCH --}}
                        @method('PUT')

                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <div class="text-danger" style="color:red;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                                <div class="text-danger" style="color:red;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Role</label>
                            <select class="form-control @error('role') is-invalid @enderror" name="role">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}" @if ($user->role == $role->name) selected @endif>
                                        {{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('role')
                                <div class="text-danger" style="color:red;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Default Region</label>
                            <select class="form-control @error('state_id') is-invalid @enderror" name="state_id">
                                <option value="0" @if ($user->state_id == 0) selected @endif>All Regions</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state->id }}" @if ($user->state_id == $state->id) selected @endif>
                                        {{ $state->name }}</option>
                                @endforeach
                            </select>
                            @error('state_id')
                                <div class="text-danger" style="color:red;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Leave blank to keep current password">
                            @error('password')
                                <div class="text-danger" style="color:red;">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>

                </div>
            </div>
        </div>
    </section>
@endsection