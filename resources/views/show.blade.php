<x-layout>
    <h1>{{ $post->title }}</h1>
    <p>Description: {{ $post->description }}</p>
    <p>Image: {{ $post->image_url }}</p>
    <p>Tag: {{ $post->tag }}</p>
    <p>Visibility: {{ $post->is_visible }}</p>
</x-layout>
