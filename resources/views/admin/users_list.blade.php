@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">User Accounts</h2>
        <button id="openAddModalButton" class="bg-blue-500 text-white px-4 py-2 rounded">Add User</button>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="min-w-full bg-white border border-gray-200 rounded">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">Name</th>
                <th class="py-2 px-4 border-b">Email</th>
                <th class="py-2 px-4 border-b">Role</th>
                <th class="py-2 px-4 border-b">Office</th>
                @if(auth()->user()->hasRole('admin'))
                    <th class="py-2 px-4 border-b">Actions</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $user->name }}</td>
                    <td class="py-2 px-4 border-b">{{ $user->email }}</td>
                    <td class="py-2 px-4 border-b">{{ $user->roles->pluck('name')->implode(', ') }}</td>
                    <td class="py-2 px-4 border-b">{{ $user->office ? $user->office->office_name : 'N/A' }}</td>
                    @if(auth()->user()->hasRole('admin'))
                        <td class="py-2 px-4 border-b">
                            @include('admin.partials.edit_button', ['user' => $user])
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded"
                                        onclick="return confirm('Are you sure you want to delete this user?');">
                                    Delete
                                </button>
                            </form>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Add/Edit User Modal -->
    <div id="userModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
        <div class="bg-white rounded-lg w-1/3 p-4 relative">
            <h2 id="modalTitle" class="text-xl font-bold mb-4">Create User</h2>
            <form id="userForm" action="{{ route('admin.storeUser') }}" method="POST">
                @csrf
                <input type="hidden" id="userId" name="user_id" value="">

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium">Name</label>
                    <input type="text" id="name" name="name" class="mt-1 p-2 block w-full border rounded" required>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium">Email</label>
                    <input type="email" id="email" name="email" class="mt-1 p-2 block w-full border rounded" required>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium">Password</label>
                    <input type="password" id="password" name="password" class="mt-1 p-2 block w-full border rounded">
                    <small class="text-gray-500">Leave blank to keep current password</small>
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="mt-1 p-2 block w-full border rounded">
                </div>

                <div class="mb-4">
                    <label for="role" class="block text-sm font-medium">Role</label>
                    <select id="role" name="role" class="mt-1 p-2 block w-full border rounded" required>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Office selection dropdown -->
                <div id="office-selection" class="mb-4 hidden">
                    <label for="office_id" class="block text-sm font-medium">Office</label>
                    <select id="office_id" name="office_id" class="mt-1 p-2 block w-full border rounded">
                        <option value="">Select Office</option>
                        @foreach($offices as $office)
                            <option value="{{ $office->id }}">{{ $office->office_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end">
                    <button type="button" id="closeModalButton" class="mr-2 bg-gray-300 text-black px-4 py-2 rounded">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('openAddModalButton').addEventListener('click', function () {
            document.getElementById('modalTitle').textContent = 'Create User';
            document.getElementById('userForm').reset();
            document.getElementById('userId').value = '';
            document.getElementById('userForm').action = '{{ route('admin.storeUser') }}';
            document.getElementById('office-selection').classList.add('hidden'); // Initially hide office selection
            document.getElementById('userModal').classList.remove('hidden');
        });

        document.querySelectorAll('.editUserButton').forEach(function(button) {
            button.addEventListener('click', function () {
                var userId = this.getAttribute('data-user');
                fetch(`/admin/users/${userId}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('modalTitle').textContent = 'Edit User';
                        document.getElementById('name').value = data.name;
                        document.getElementById('email').value = data.email;
                        document.getElementById('role').value = data.roles[0].name;
                        if (data.roles[0].name === 'head') {
                            document.getElementById('office-selection').classList.remove('hidden');
                            document.getElementById('office_id').value = data.office_id;
                        } else {
                            document.getElementById('office-selection').classList.add('hidden');
                        }
                        document.getElementById('userId').value = data.id;
                        document.getElementById('userForm').action = `/admin/users/${userId}`;
                        document.getElementById('userModal').classList.remove('hidden');
                    });
            });
        });

        document.getElementById('closeModalButton').addEventListener('click', function () {
            document.getElementById('userModal').classList.add('hidden');
        });

        document.getElementById('role').addEventListener('change', function () {
            var role = this.value;
            var officeSelection = document.getElementById('office-selection');
            if (role === 'head') {
                officeSelection.classList.remove('hidden');
            } else {
                officeSelection.classList.add('hidden');
            }
        });
    </script>
@endsection
