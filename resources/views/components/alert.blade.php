@if (session('success'))
    <div id="alert"
        class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-white text-black p-4 rounded shadow-lg transition-transform duration-300 ease-in-out translate-y-[-100px] opacity-0">
        {{ session('success') }}
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alert = document.getElementById('alert');
            alert.classList.remove('translate-y-[-100px]', 'opacity-0');
            alert.classList.add('translate-y-0', 'opacity-100');

            setTimeout(() => {
                alert.classList.remove('translate-y-0', 'opacity-100');
                alert.classList.add('translate-y-[-100px]', 'opacity-0');
            }, 3000);
        });
    </script>
@endif
