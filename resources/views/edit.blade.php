<x-layout>
    <div class="max-w-md mx-auto">
        <h1 class="text-4xl text-white font-sans my-4 text-left">Edit your post</h1>
        <form action="{{ route('posts.update', $post->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="relative z-0 w-full mb-5 group">
                <input type="text" id="title" name="title" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " value="{{ $post->title }}" required />
                <label for="title" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Title</label>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input type="text" id="description" name="description" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " value="{{ $post->description }}" required />
                <label for="description" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Description</label>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input type="text" id="image_url" name="image_url" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " value="{{ $post->image_url }}" required />
                <label for="image_url" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Image URL</label>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <select id="tag" name="tag" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" required>
                    <option class="bg-gray-900" value="" disabled>Select a tag</option>
                    <option class="bg-gray-900" value="Warhammer 40K" {{ $post->tag == 'Warhammer 40K' ? 'selected' : '' }}>Warhammer 40K</option>
                    <option class="bg-gray-900" value="Warhammer AOS" {{ $post->tag == 'Warhammer AOS' ? 'selected' : '' }}>Warhammer AOS</option>
                    <option class="bg-gray-900" value="GW Middle Earth" {{ $post->tag == 'GW Middle Earth' ? 'selected' : '' }}>GW Middle Earth</option>
                    <option class="bg-gray-900" value="Dungeons & Dragons" {{ $post->tag == 'Dungeons & Dragons' ? 'selected' : '' }}>Dungeons & Dragons</option>
                    <option class="bg-gray-900" value="Pathfinder" {{ $post->tag == 'Pathfinder' ? 'selected' : '' }}>Pathfinder</option>
                    <option class="bg-gray-900" value="Reaper Miniatures" {{ $post->tag == 'Reaper Miniatures' ? 'selected' : '' }}>Reaper Miniatures</option>
                    <option class="bg-gray-900" value="Custom Made" {{ $post->tag == 'Custom Made' ? 'selected' : '' }}>Custom Made</option>
                    <option class="bg-gray-900" value="Other" {{ $post->tag == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
                <label for="tag" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Tag</label>
            </div>
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Update</button>
        </form>
    </div>
</x-layout>
