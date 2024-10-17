<x-layout>
    <h1 class="text-4xl text-white font-sans my-4">About Mighty Models</h1>

    <p class="text-xl text-gray-500 dark:text-gray-400">
        Mighty Models is a website for showing your miniature models to the world. It does not matter whether you like Warhammer, Dungeons & Dragons or anything else, there is something here for everybody. You can see the models of other users on the
        <a href="{{ route('posts') }}" class="font-semibold text-gray-900 underline dark:text-white decoration-blue-700">posts</a> page. If you see some really nice models, you can give them a like. Before you can like models, you must be logged in first. You can create an
        <a href="{{ route('register') }}" class="font-semibold text-gray-900 underline dark:text-white decoration-blue-700">account</a> or
        <a href="{{ route('login') }}" class="font-semibold text-gray-900 underline dark:text-white decoration-blue-700">login</a> at the top of this page. When you have liked at least five posts, you can start posting your own content. When you post content on the
        <a href="{{ route('posts.create') }}" class="font-semibold text-gray-900 underline dark:text-white decoration-blue-700">create</a> page, you need to have a title, description, and image. You then have to select one of the tags that applies to your model.
    </p>

</x-layout>
