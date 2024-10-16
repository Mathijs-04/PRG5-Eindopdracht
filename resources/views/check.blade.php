<x-layout>
    @auth
        <h1 class="pb-[70vh]">This user is logged in</h1>
    @else
        <h1 class="pb-[70vh]">This user is not logged in</h1>
    @endauth
</x-layout>
