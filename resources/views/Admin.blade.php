<x-layout>
    @if (auth()->user()->is_admin)
        <h1 class="text-4xl text-white font-sans my-4">Welcome Admin</h1>
    @else
        <h1 class="text-4xl text-white font-sans my-4">You are not the Admin, get out of here!</h1>
        <a href="/" class="text-2xl text-blue-500 hover:text-blue-700 underline">Home</a>
    @endif
</x-layout>
