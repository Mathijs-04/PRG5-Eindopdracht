<x-layout>
    @if (auth()->check() && auth()->user()->is_admin)
        <h1 class="text-4xl text-white font-sans my-4">Manage visibility</h1>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg pb-10">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Post title
                    </th>
                    <th scope="col" class="px-6 py-3">
                        User
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Creation date
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Visibility
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Toggle
                    </th>
                </tr>

                </thead>
                @foreach($posts as $post)
                    <tbody>
                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $post->title }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $post->user->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $post->created_at }}
                        </td>
                        <td class="px-6 py-4">
                            @if($post->is_visible == 1)
                                {{ 'Visible' }}
                            @else
                                {{ 'Hidden' }}
                            @endif

                        </td>
                        <td class="px-6 py-4">
                            <form action="{{ route('admin.posts.toggleVisibility', $post) }}" method="POST">
                                @csrf
                                <button type="submit" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                    {{ $post->is_visible ? 'Hide' : 'Show' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    </tbody>
                @endforeach
            </table>
        </div>

    @else
        <script>
            window.location.href = " {{ route('home') }}"
        </script>
    @endif
</x-layout>
