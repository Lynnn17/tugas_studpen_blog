<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Categories') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-6 w-full">
        <x-alert />
        <div class="flex justify-between mb-4">
            <h1 class="text-2xl font-bold text-white">Post List</h1>
            <button id="" class="bg-blue-500 text-white px-4 py-2 rounded"
                onclick="toggleModal('createPostModal')">
                Create New Post
            </button>
        </div>

        <table id="postsTable"
            class="min-w-full bg-white border border-gray-300 rounded-lg overflow-hidden text-center">
            <thead class="">
                <tr class="bg-gray-200">
                    <th class="py-2 px-4 border">No</th>
                    <th class="py-2 px-4 border">Title</th>
                    <th class="py-2 px-4 border">Content</th>
                    <th class="py-2 px-4 border">Author</th>
                    <th class="py-2 px-4 border">Category</th>
                    <th class="py-2 px-4 border">Photo</th>
                    <th class="py-2 px-4 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                    <tr>
                        <td class="py-2 px-4 border">{{ $loop->iteration }}</td>
                        <td class="py-2 px-4 border">{{ $post->title }}</td>
                        <td class="py-2 px-4 border">
                            {{ Str::limit($post->content, 7) }}
                            <br />
                            <button onclick="showContentModal('{{ $post->id }}')" class="text-blue-500">Read
                                More</button>

                        </td>
                        <td class="py-2 px-4 border">{{ $post->user->name }}</td>
                        <td class="py-2 px-4 border">{{ $post->category->name }}</td>
                        <td class="py-2 px-4 border">
                            @if ($post->photo)
                                <img src="{{ asset('storage/' . $post->photo) }}" alt="Post Photo" class="w-16 h-16">
                            @endif
                        </td>
                        <td class="py-2 px-4 border">
                            <x-secondary-button class="text-blue-500"
                                onclick="openEditModal({{ $post->id }}, '{{ $post->title }}', '{{ $post->content }}', '{{ $post->category_id }}')">Edit</x-secondary-button>
                            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <x-danger-button type="submit" class="text-red-500">Delete</x-danger-button>
                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>

    </div>




    <x-modal id="createPostModal" title="Create New Post" action="{{ route('posts.store') }}" formId="createPostForm"
        buttonText="Create">
        <div class="mb-4">
            <label for="title" class="block text-white">Title</label>
            <input type="text" name="title" id="title"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        </div>
        <div class="mb-4">
            <label for="content" class="block text-white">Content</label>
            <textarea name="content" id="content" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" rows="4"
                required></textarea>
        </div>
        <div class="mb-4">
            <label for="category_id" class="block text-white">Category</label>
            <select name="category_id" id="category_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="photo" class="block text-white">Photo</label>
            <input type="file" name="photo" id="photo"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-white">
        </div>
    </x-modal>


    <x-modal id="editPostModal" title="Edit Post" action="" formId="editPostForm" buttonText="Update">
        <input type="hidden" name="_method" value="PUT">
        <div class="mb-4 ">
            <label for="edit_title" class="block text-white">Title</label>
            <input type="text" name="title" id="edit_title"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        </div>
        <div class="mb-4 =">
            <label for="edit_content" class="block text-white">Content</label>
            <textarea name="content" id="edit_content" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" rows="4"
                required></textarea>
        </div>
        <div class="mb-4 ">
            <label for="edit_category_id" class="block text-white">Category</label>
            <select name="category_id" id="edit_category_id"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4 ">
            <label for="edit_photo" class="block text-white">Photo</label>
            <input type="file" name="photo" id="edit_photo"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-white">
        </div>
    </x-modal>

    <x-modal id="contentModal" title="Post Details" action="" formId="" buttonText="">
        <h2 class="text-xl font-bold mb-4 text-white" id="modalTitle"></h2>
        <p id="modalContent" class="text-white"></p>
    </x-modal>

</x-app-layout>

<script>
    $(document).ready(function() {
        $('#postsTable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari Post   ...",
                lengthMenu: "Tampilkan _MENU_ data",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                }
            }
        });


        $('div.dataTables_filter input').addClass('border rounded-lg p-2 text-white');
        $('div.dataTables_length select').addClass('border rounded-lg p-2 text-white');
        $('div.dataTables_length label').addClass(' p-2 text-white');
        $(
            'div.dataTables_info'
        ).addClass('p-2 !text-white');
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


            editCategoryForm.action = `{{ url('categories') }}/${categoryId}`;
            editNameInput.value = categoryName;

            editCategoryModal.classList.remove('hidden');
        });
    });

    function toggleModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.toggle('hidden');
    }

    function openEditModal(postId, title, content, categoryId) {
        const modal = document.getElementById('editPostModal');


        const form = document.getElementById('editPostForm');
        form.action = `/posts/${postId}`;


        document.getElementById('edit_title').value = title;
        document.getElementById('edit_content').value = content;
        document.getElementById('edit_category_id').value = categoryId;


        toggleModal('editPostModal');
    }

    function showContentModal(postId) {
        const posts = @json($posts);
        const post = posts.find(p => p.id == postId);

        document.getElementById('modalTitle').innerText = post.title;
        document.getElementById('modalContent').innerText = post.content;

        toggleModal('contentModal');
    }

    function toggleModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.toggle('hidden');
    }
</script>
