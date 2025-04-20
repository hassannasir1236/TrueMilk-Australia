@php
    $activePage = 'setting'; // or 'inventory', 'dashboard', etc.
@endphp
@extends('layouts.app')

@section('content')
  <!-- Settings Section -->
  <section id="settings" class="" style="width: -webkit-fill-available;background: #fff;padding: 25px;border-radius: 10px;margin: 1px 13px 37px 11px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);">
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
                        <form class="settings-form">
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" value="Administrator User" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Email Address</label>
                                <input type="email" value="admin@australiandairy.com" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Role</label>
                                <select class="form-control">
                                    <option selected>Administrator</option>
                                    <option>Regional Manager</option>
                                    <option>Data Analyst</option>
                                    <option>Supplier Manager</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Default Region</label>
                                <select class="form-control">
                                    <option selected>All Regions</option>
                                    <option>New South Wales</option>
                                    <option>Queensland</option>
                                    <option>Western Australia</option>
                                    <option>Victoria</option>
                                </select>
                            </div>
                            <button type="button" class="btn">Update Profile</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
@endsection