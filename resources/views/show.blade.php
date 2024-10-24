<x-layout>
    <div class="flex flex-col md:flex-row bg-gray-800 rounded-lg p-6 mb-6 shadow-lg">
        <div class="md:w-1/2">
            <img src="{{ $post->image ? asset($post->image) : $post->image_url }}" alt="Image for {{ $post->title }}" class="w-full h-auto rounded-lg">
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
            <p class="text-gray-300 mt-2">
                <span class="font-semibold">♥ </span> {{ $likeCount }}
            </p>
            <div class="flex space-x-2 mt-3">
                <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Like
                </button>
                @auth
                    @if((auth()->user()->is_admin) || ((auth()->user()->id) === ($post->user_id)))
                        <a href="{{ route('posts.edit', $post->id) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Edit
                        </a>
                        <form action="{{ route('posts.destroy', $post) }}" method="POST"
                              onsubmit="return confirm('Delete this post?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                Delete
                            </button>
                        </form>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</x-layout>
