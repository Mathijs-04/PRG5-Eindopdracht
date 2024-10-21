<x-layout>
    @if (auth()->user()->is_admin)
        <h1 class="text-4xl text-white font-sans my-4">Welcome Admin</h1>
    @else
        <script>
            window.location.href = " {{ route('home') }}"
        </script>
    @endif
</x-layout>
