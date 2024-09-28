{{-- @extends('layouts.admin')

@section('content')

    <!-- Edit Service Modal -->
    <div id="editServiceModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg w-1/3 p-6">
            <h2 class="text-xl font-bold mb-4">Edit Service</h2>

            <form id="editServiceForm" action="#" method="POST">
                @csrf
                @method('PATCH')
                <div>
                    <label for="edit_service_name">Service Name:</label>
                    <input type="text" name="service_name" id="edit_service_name" required class="border rounded-lg p-2 w-full">
                </div>

                <div class="mt-4">
                    <label for="edit_description">Description:</label>
                    <textarea name="description" id="edit_description" class="border rounded-lg p-2 w-full"></textarea>
                </div>

                <div class="mt-4">
                    <label for="edit_classification">Classification:</label>
                    <select name="classification" id="edit_classification" required class="border rounded-lg p-2 w-full">
                        <option value="SIMPLE">SIMPLE</option>
                        <option value="COMPLEX">COMPLEX</option>
                        <option value="SIMPLE - COMPLEX">SIMPLE - COMPLEX</option>
                        <option value="HIGHLY TECHNICAL">HIGHLY TECHNICAL</option>
                    </select>
                </div>

                <div class="mt-4">
                    <label for="edit_transaction_id">Type of Transaction:</label>
                    <select name="transaction_id" id="edit_transaction_id" required class="border rounded-lg p-2 w-full">
                        @foreach($transactions as $transaction)
                            <option value="{{ $transaction->id }}">{{ $transaction->type_of_transaction }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-4">
                    <label for="edit_checklist_of_requirements">Checklist of Requirements:</label>
                    <textarea name="checklist_of_requirements" id="edit_checklist_of_requirements" class="border rounded-lg p-2 w-full"></textarea>
                </div>

                <div class="mt-4">
                    <label for="edit_where_to_secure">Where to Secure:</label>
                    <textarea name="where_to_secure" id="edit_where_to_secure" class="border rounded-lg p-2 w-full"></textarea>
                </div>

                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 mt-4">Update Service</button>
            </form>

            <button class="mt-4 bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600" onclick="document.getElementById('editServiceModal').style.display='none'">Close</button>
        </div>
    </div>

    <script>
        function editService(serviceId) {
            fetch(`/services/edit/${serviceId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('edit_service_name').value = data.service_name;
                    document.getElementById('edit_description').value = data.description;
                    document.getElementById('edit_classification').value = data.classification;
                    document.getElementById('edit_transaction_id').value = data.transaction_id;
                    document.getElementById('edit_checklist_of_requirements').value = data.checklist_of_requirements;
                    document.getElementById('edit_where_to_secure').value = data.where_to_secure;

                    // Update form action to point to the correct service update route
                    document.getElementById('editServiceForm').action = `/services/update/${serviceId}`;

                    // Show the edit modal
                    document.getElementById('editServiceModal').style.display = 'flex';
                })
                .catch(error => console.error('Error fetching service data:', error));
        }

        // Function to close the modal when clicked outside
        window.onclick = function(event) {
            const editModal = document.getElementById('editServiceModal');
            if (event.target === editModal) {
                editModal.style.display = 'none';
            }
        }
    </script>
@endsection --}}
