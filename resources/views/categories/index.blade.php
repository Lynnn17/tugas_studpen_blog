<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Categories') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-6 w-full">
        <x-alert />
        <div class="flex justify-between mb-4">
            <h1 class="text-2xl font-bold text-white">Category List</h1>
            <button id="openAddCategoryModal" class="bg-blue-500 text-white px-4 py-2 rounded"
                onclick="toggleModal('addCategoryModal')">
                Add Category
            </button>
        </div>

        <table id="categoriesTable"
            class="min-w-full bg-white border border-gray-300 rounded-lg overflow-hidden text-center">
            <thead class="">
                <tr class="bg-gray-200">
                    <th class="py-2 px-4 border">No</th>
                    <th class="py-2 px-4 border">Name</th>
                    <th class="py-2 px-4 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td class="py-2 px-4 border">{{ $loop->iteration }}</td>
                        <td class="py-2 px-4 border">{{ $category->name }}</td>
                        <td class="py-2 px-4 border">
                            <x-secondary-button data-id="{{ $category->id }}" data-name="{{ $category->name }}"
                                class="text-blue-500 edit-category">
                                Edit
                            </x-secondary-button>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <x-danger-button type="submit" class="text-red-500 ml-2">Delete</x-danger-button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <!-- Modal for Add Category -->
    <x-modal id="addCategoryModal" title="Add Category" action="{{ route('categories.store') }}"
        formId="createCategoryForm" buttonText="Create">
        <div class="mb-4">
            <label for="name" class="block">Name</label>
            <input type="text" name="name" id="name"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        </div>
    </x-modal>

    <!-- Modal for Edit Category -->
    <x-modal id="editCategoryModal" title="Edit Category" action="" formId="editCategoryForm" buttonText="Update">
        <input type="hidden" name="_method" value="PUT">
        <div class="mb-4">
            <label for="edit-name" class="block">Name</label>
            <input type="text" name="name" id="edit-name"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        </div>
    </x-modal>

    <script>
        $(document).ready(function() {
            $('#categoriesTable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Cari kategori...",
                    lengthMenu: "Tampilkan _MENU_ data",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    }
                }
            });

            // Styling DataTable elements
            $('div.dataTables_filter input').addClass('border rounded-lg p-2 text-white');
            $('div.dataTables_length select').addClass('border rounded-lg p-2 text-white');
            $('div.dataTables_length label').addClass('p-2 text-white');
            $('div.dataTables_info').addClass('p-2 !text-white');
            $('div.dataTables_paginate .paginate_button').addClass(
                'bg-blue-500 text-white rounded-lg px-3 py-1 mx-1');
            $('div.dataTables_paginate .paginate_button.current').addClass('bg-green-500 text-white font-bold');
        });

        const editCategoryButtons = document.querySelectorAll('.edit-category');
        const editCategoryModal = document.getElementById('editCategoryModal');
        const editCategoryForm = document.getElementById('editCategoryForm');
        const editNameInput = document.getElementById('edit-name');

        editCategoryButtons.forEach(button => {
            button.addEventListener('click', () => {
                const categoryId = button.getAttribute('data-id');
                const categoryName = button.getAttribute('data-name');

                // Set form action and value
                editCategoryForm.action = `{{ url('categories') }}/${categoryId}`;
                editNameInput.value = categoryName;

                // Show modal
                editCategoryModal.classList.remove('hidden');
            });
        });
    </script>
</x-app-layout>
