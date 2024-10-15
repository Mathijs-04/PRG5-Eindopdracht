<x-layout>
    <h1 class="mb-[5vh]">Welcome to the Posts page</h1>
    @foreach($posts as $post)
        <section>
            <br>
            {{ $post ->title }}
            <br>
            {{ $post ->image_url }}
            <br>
            <a href="{{ route('show', ['id' => $post->id]) }}">Details</a>
            <br>
        </section>
    @endforeach
</x-layout>
