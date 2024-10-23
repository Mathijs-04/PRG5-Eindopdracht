<x-layout>
    <section class="pt-10 pb-5 pl-5 pr-5">
        <h1 class="text-4xl text-white font-sans my-4">About Mighty Models</h1>

        <p class="text-xl text-gray-500 dark:text-gray-400">
            Mighty Models is a website for showcasing your miniature models to the world. Whether you are into Warhammer, Dungeons & Dragons, or any other miniature models, there is something here for everyone. You can view models from other users on the
            <a href="{{ route('posts') }}" class="font-semibold text-gray-900 underline dark:text-white decoration-blue-700">posts</a> page. If you find some models you really like, you can give them a like. Before you can like models, you must be logged in. You can create an
            <a href="{{ route('register') }}" class="font-semibold text-gray-900 underline dark:text-white decoration-blue-700">account</a> or
            <a href="{{ route('login') }}" class="font-semibold text-gray-900 underline dark:text-white decoration-blue-700">log in</a> at the top of this page. Once you are logged in and have liked at least five posts, you can start posting your own content. When posting content on the
            <a href="{{ route('posts.create') }}" class="font-semibold text-gray-900 underline dark:text-white decoration-blue-700">create</a> page, you need to provide a title, description, and image. You also need to select one of the tags that applies to your model.
        </p>

        <div class="flex justify-around mt-8">
            <img class="w-1/3" src="{{ asset('images/dragon.webp') }}" alt="dragon">
            <img class="w-1/3" src="{{ asset('images/captain.webp') }}" alt="captain">
        </div>
    </section>
</x-layout>
