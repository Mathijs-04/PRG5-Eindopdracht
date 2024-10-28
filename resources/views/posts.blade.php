<x-layout>
    <div class="container mx-auto pt-5 flex flex-col min-h-screen">
        <div class="flex justify-center items-center relative">
            <form id="search" action="{{ route('posts.search') }}" method="GET" class="max-w-md">
                @csrf
                <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                <div class="relative flex">
                    <div class="relative">
                        <select id="dropdown" name="tag" class="block p-4 text-sm text-gray-900 border border-gray-300 rounded-l-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option class="bg-gray-900" value="" disabled selected>Tag</option>
                            <option class="bg-gray-900" value="Warhammer 40K">Warhammer 40K</option>
                            <option class="bg-gray-900" value="Warhammer AOS">Warhammer AOS</option>
                            <option class="bg-gray-900" value="GW Middle Earth">GW Middle Earth</option>
                            <option class="bg-gray-900" value="Dungeons & Dragons">Dungeons & Dragons</option>
                            <option class="bg-gray-900" value="Other">Other</option>
                        </select>
                    </div>
                    <div class="relative flex-grow">
                        <input type="search" id="search" name="search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-r-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search posts..." />
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>
                    </div>
                    <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
                </div>
            </form>
            @if($isSearchResult)
                <a href="{{ route('posts') }}" class="absolute right-0 block p-4 pr-7 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 flex items-center">
                    <svg class="rtl:rotate-180 w-3.5 h-3.5 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5H1m0 0 4-4M1 5l4 4"/>
                    </svg>
                    See all posts
                </a>
            @else
                <form action="{{ route('posts') }}" method="GET" class="absolute right-0">
                    @csrf
                    <select name="sort" onchange="this.form.submit()" class="block p-4 pr-7 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="date_desc" {{ request('sort') === 'date_desc' ? 'selected' : '' }}>Newest</option>
                        <option value="date_asc" {{ request('sort') === 'date_asc' ? 'selected' : '' }}>Oldest</option>
                        <option value="likes_desc" {{ request('sort') === 'likes_desc' ? 'selected' : '' }}>Most Likes</option>
                        <option value="likes_asc" {{ request('sort') === 'likes_asc' ? 'selected' : '' }}>Least Likes</option>
                    </select>
                </form>
            @endif
        </div>
        <div class="grid-container pt-5 flex-grow">
            @if($errorMessage)
                <div class="text-4xl text-white font-sans my-4 text-left mb-96">
                    {{ $errorMessage }}
                </div>
            @endif
            @foreach($posts as $post)
                @if($post->is_visible == 1)
                    <div class="max-w-sm bg-black-600 border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 max-h-96 overflow-hidden">
                        <a href="#">
                            <img class="rounded-t-lg" src="{{ $post->image ? asset($post->image) : $post->image_url }}" alt="post"/>
                        </a>
                        <div class="p-5">
                            <a href="#">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $post->title }}</h5>
                            </a>
                            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ $post->tag }}</p>
                            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">♥ {{ $post->likeCount }}</p>
                            <a href="{{ route('show', ['id' => $post->id]) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                Details
                                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    <div class="pb-[20vh]"></div>
</x-layout>

<style>
    .grid-container {
        display: grid;
        grid-template-columns: 1fr;
        gap: 50px;
        max-width: 1200px;
        margin: 0 auto;
    }

    @media (min-width: 768px) {
        .grid-container {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    .max-h-96 {
        max-height: 40rem;
    }

    .overflow-hidden {
        overflow: hidden;
    }
</style>
