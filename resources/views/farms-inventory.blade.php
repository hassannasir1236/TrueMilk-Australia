@php
    $activePage = 'inventory'; // or 'inventory', 'dashboard', etc.
@endphp
@extends('layouts.app')

@section('content')
    <section id="farms-inventory" class="">
        <div class="metrics-container">


            <form id="" method="POST" action="{{ route('farm-inventory.store') }}" style="width: -webkit-fill-available;background: #fff;padding: 25px;border-radius: 10px;max-width: 800px;margin: 0 auto 40px auto; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);">
                @csrf

                <h3 style="text-align: center;">Farm Inventory</h3>
                <input type="hidden" name="id" value="{{ old('id', $inventory->id ?? '') }}">

                @if(session('success'))
                    <div class="alert-success"
                        style="background-color: #d4edda; color: #155724; text-align: center; padding: 10px; margin-bottom: 10px;">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="form-group">
                    <label for="state_id">State</label>
                    <select name="state_id" id="state_id">
                        <option value="">-- Select State --</option>
                        @foreach($states as $state)
                            <option value="{{ $state->id }}" {{ old('state_id', $inventory->state_id ?? '') == $state->id ? 'selected' : '' }}>
                                {{ $state->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('state_id')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="farm_id">Farm</label>
                    <select name="farm_id" id="farm_id">
                        <option value="">-- Select Farm --</option>
                        @if(old('state_id') || isset($inventory->state_id))
                            @foreach($farms as $farm)
                                <option value="{{ $farm->id }}" {{ old('farm_id', $inventory->farm_id ?? '') == $farm->id ? 'selected' : '' }}>
                                    {{ $farm->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('farm_id')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="farm_item_id">Farm Item</label>
                    <select name="farm_item_id" id="farm_item_id">
                        <option value="">-- Select Item --</option>
                        @foreach($items as $item)
                            <option value="{{ $item->id }}" {{ old('farm_item_id', $inventory->farm_item_id ?? '') == $item->id ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('farm_item_id')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" name="quantity" step="0.01"
                        value="{{ old('quantity', $inventory->quantity ?? '') }}">
                    @error('quantity')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="unit">Unit</label>
                    <select name="unit" id="unit">
                        <option value="">-- Select Unit --</option>
                        <option value="liters" {{ old('unit', $inventory->unit ?? '') == 'liters' ? 'selected' : '' }}>Liters
                        </option>
                        <option value="kg" {{ old('unit', $inventory->unit ?? '') == 'kg' ? 'selected' : '' }}>Kilograms
                        </option>
                    </select>
                    @error('unit')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="unit_price">Enter Per Liter/Kg Price</label>
                    <input type="number" name="unit_price" id="unit_price" class="form-control" step="0.01"
                        value="{{ old('unit_price', $inventory->total_price ?? '') }}" placeholder="Enter Per Liter/Kg Price">
                    @error('unit_price')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="collected_on">Collected Date</label>
                    <input type="date" name="collected_on"
                        value="{{ old('collected_on', $inventory->collected_on ?? '') }}">
                    @error('collected_on')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                    <textarea name="notes" id="notes" rows="4"
                        class="form-control"
                    >{{ old('notes', $inventory->notes ?? '') }}</textarea>
                    @error('notes')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>


                <button type="submit">{{ isset($inventory) ? 'Update' : 'Save' }}</button>
            </form>

            <div class="data-container">
                <div class="data-card">
                    <h4>Farms Details</h4>
                    <div class="table-responsive">
                        <table class="data-table">


                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>State</th>
                                    <th>Farm</th>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                    <th>Date</th>
                                    <th>Notes</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($inventories as $inv)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $inv->farm->state->name }}</td>
                                        <td>{{ $inv->farm->name }}</td>
                                        <td>{{ $inv->item->name }}</td>
                                        <td>{{ $inv->quantity }}</td>
                                        <td>{{ $inv->unit }}</td>
                                        <td>{{ $inv->collected_on }}</td>
                                        <td>{{ $inv->notes }}</td>
                                        <td>
                                            <a href="{{ route('farm-inventory.edit', $inv->id) }}" class="btn-icon"><i
                                                    class="fas fa-edit"></i></a>
                                            <form action="{{ route('farm-inventory.destroy', $inv->id) }}" method="POST"
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

    <!-- Dynamic farm dropdown loading via JS -->
    <script>
        document.getElementById('state_id').addEventListener('change', function () {
            const stateId = this.value;
            const oldFarmId = '{{ old("farm_id", $inventory->farm_id ?? "") }}';

            if (!stateId) {
                // If no state is selected, reset the farm dropdown
                document.getElementById('farm_id').innerHTML = '<option value="">-- Select Farm --</option>';
                return;
            }

            // Make the request to get farms by selected state
            fetch(`/farms/by-state/${stateId}`)
                .then(response => response.json())
                .then(data => {
                    const farmSelect = document.getElementById('farm_id');
                    farmSelect.innerHTML = '<option value="">-- Select Farm --</option>';

                    // Populate the farm select with farms returned from the backend
                    data.forEach(farm => {
                        const selected = farm.id == oldFarmId ? 'selected' : ''; // Check if this farm is the old one
                        farmSelect.innerHTML += `<option value="${farm.id}" ${selected}>${farm.name}</option>`;
                    });
                })
                .catch(error => {
                    console.error('Error fetching farms:', error);
                });
        });
    </script>

@endsection