@php
    $activePage = 'farms'; // or 'inventory', 'dashboard', etc.
@endphp
@extends('layouts.app')

@section('content')
    <!-- Add/Update Farms details -->
    <section id="farms" class="">

        <div class="metrics-container">
         
            <form id="farmForm" action="{{ route('farms.store') }}" method="POST" style="width: -webkit-fill-available;">
            <h3 style="text-align:center;">{{ isset($farm) ? 'Edit Farm' : 'Add New Farm' }}</h3>
                @csrf


                @if(session('success'))
                    <div class="alert-success"
                        style="background-color: #d4edda; color: #155724; text-align: center; padding: 10px; margin-bottom: 10px; border: 1px solid #c3e6cb;">
                        {{ session('success') }}
                    </div>
                @endif
                <input type="hidden" name="id" id="farm_id" value="{{ old('id', $farm->id ?? '') }}">

                <div class="form-group">
                    <label for="name">Farm Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $farm->name ?? '') }}" />
                    @error('name')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" name="address" id="address" value="{{ old('address', $farm->address ?? '') }}" />
                    @error('address')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $farm->phone ?? '') }}" />
                    @error('phone')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="farm_size">Area (in acres)</label>
                    <input type="number" name="farm_size" id="area"
                        value="{{ old('farm_size', $farm->farm_size ?? '') }}" />
                    @error('farm_size')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="state">State</label>
                    <select name="state_id" id="state_id">
                        <option value="">-- Select State --</option>
                        @foreach ($states as $state)
                            <option value="{{ $state->id }}" {{ old('state_id', $farm->state_id ?? '') == $state->id ? 'selected' : '' }}>
                                {{ $state->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('state_id')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description"
                        rows="4">{{ old('description', $farm->description ?? '') }}</textarea>
                    @error('description')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit">{{ isset($farm) ? 'Update' : 'Save' }}</button>
            </form>

            <div class="data-container" style="height: 770px;border-radius:15px;">
                <div class="data-card" style="height: auto;">
                    <h4>Farms Details</h4>
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Farm Name</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Area</th>
                                    <th>State</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                @php $i = 1; @endphp
                                @foreach ($farms as $farm)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $farm->name }}</td>
                                        <td>{{ $farm->address }}</td>
                                        <td>{{ $farm->phone }}</td>
                                        <td>{{ $farm->farm_size }}</td>
                                        <td>{{ $farm->state->name }}</td>
                                        <td>{{ $farm->description }}</td>
                                        <td>
                                            <a href="{{ route('farms.edit', $farm->id) }}" class="btn-icon"><i
                                                    class="fas fa-edit"></i></a>
                                            <form action="{{ route('farms.destroy', $farm->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-icon delete-button"><i
                                                        class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection