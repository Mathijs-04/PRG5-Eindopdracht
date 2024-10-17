<x-layout>
    <h1 class="text-4xl text-white font-sans my-4">Welcome to the Create page</h1>
    <form action="{{ url(route('posts.store')) }}" method="POST">
        @csrf
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required/>
        <label for="description">Description:</label>
        <input type="text" id="description" name="description" required/>
        <label for="image_url">Image URL:</label>
        <input type="text" id="image_url" name="image_url" required/>
        <label for="tag">Tag:</label>
        <input type="text" id="tag" name="tag" required/>
        <button type="submit">Save</button>
    </form>
</x-layout>
