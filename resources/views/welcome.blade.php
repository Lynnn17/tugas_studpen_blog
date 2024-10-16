<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-white text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Berita') }}
        </h2>
    </x-slot>

    <div class="container mx-auto my-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($posts as $post)
                <div
                    class="bg-white rounded-lg shadow-lg overflow-hidden transition-transform transform hover:scale-105 hover:shadow-xl">
                    <img class="h-48 w-full object-cover" src="{{ asset('storage/' . $post->photo) }}" alt="Berita Image">

                    <div class="p-4">
                        <h3 class="text-xl font-bold text-gray-800 hover:text-indigo-500 transition-colors">
                            {{ $post->title }}</h3>
                        <div class="flex justify-between mt-2 text-gray-500 text-sm">
                            <span>Author: {{ $post->user->name }}</span>
                            <span>Kategori: {{ $post->category->name }}</span>
                        </div>
                        <p class="mt-2 text-gray-600">{{ Str::limit($post->content, 50) }}</p>
                        <button onclick="showContentModal('{{ $post->id }}')"
                            class="mt-4 inline-block bg-indigo-600 text-white rounded-md px-4 py-2 hover:bg-indigo-700 transition-colors font-semibold">Baca
                            Selengkapnya &rarr;</button>

                    </div>
                </div>
            @endforeach
        </div>

    </div>

    <!-- Modal component -->
    <x-modal id="contentModal" title="Post Details" action="" formId="" buttonText="">
        <img id="modalImage" class="h-48 w-full object-cover rounded mb-4" alt="Post Image">
        <h2 class="text-xl font-bold mb-4 text-white" id="modalTitle"></h2>
        <p class="text-sm text-gray-400 mb-2" id="modalAuthor"></p>
        <p class="text-sm text-gray-400 mb-4" id="modalCategory"></p>
        <p id="modalContent" class="text-white"></p>
    </x-modal>



    <script>
        function showContentModal(postId) {
            const posts = @json($posts);
            const post = posts.find(p => p.id == postId);

            document.getElementById('modalImage').src = '{{ asset('storage') }}/' + post.photo;
            document.getElementById('modalTitle').innerText = post.title;
            document.getElementById('modalAuthor').innerText = 'Author: ' + post.user
                .name;
            document.getElementById('modalCategory').innerText = 'Kategori: ' + post.category
                .name;
            document.getElementById('modalContent').innerText = post.content;

            toggleModal('contentModal');
        }

        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.toggle('hidden');
        }
    </script>

</x-guest-layout>
