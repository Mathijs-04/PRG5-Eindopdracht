<x-layout>
    <div class="flex flex-col md:flex-row bg-gray-800 rounded-lg p-6 mb-6 shadow-lg">
        <div class="md:w-1/2">
            <img src="{{ $post->image_url }}" alt="Image for {{ $post->title }}" class="w-full h-auto rounded-lg">
        </div>
        <div class="md:w-1/2 md:pl-6 mt-4 md:mt-0">
            <h1 class="text-3xl font-semibold text-white">{{ $post->title }}</h1>
            <p class="text-gray-300 mt-2">
                <span class="font-semibold">Description:</span> {{ $post->description }}
            </p>
            <p class="text-gray-300 mt-2">
                <span class="font-semibold">Tag:</span> {{ $post->tag }}
            </p>
            <p class="text-gray-300 mt-2">
                <span class="font-semibold">Posted by:</span> {{ $post->user->name }}
            </p>
        </div>
    </div>
</x-layout>
