<x-layout>
    <h1 class="mb-[5vh]">Welcome to the Posts page</h1>
    <ul>
        @foreach($posts as $post)
            <li>{{ $post ->title }}</li>
        @endforeach
    </ul>
</x-layout>
