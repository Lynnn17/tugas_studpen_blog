<div id="{{ $id }}" class="fixed inset-0 flex items-center justify-center z-50 hidden">
    <div class="bg-gray-800 rounded-lg shadow-lg w-11/12 sm:w-1/3">
        <div class="p-6">
            <h3 class="text-lg font-bold text-white mb-4">{{ $title }}</h3>
            <form action="{{ $action }}" method="POST" id="{{ $formId }}" enctype="multipart/form-data">
                @csrf
                @if (!empty($method))
                    @method($method)
                @endif

                {{ $slot }}
                <div class="flex justify-end">
                    @if ($buttonText)
                        <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded">{{ $buttonText }}</button>
                    @endif
                    <button type="button" class="text-gray-300 hover:text-gray-400 ml-4"
                        onclick="toggleModal('{{ $id }}')">
                        Close
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.toggle('hidden');
    }
</script>
