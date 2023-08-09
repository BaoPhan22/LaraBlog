<x-app-layout :meta-title='$post->meta_title ?: $post->title' :meta-description='$post->meta_description'>
    <!-- Post Section -->
    <section class="w-full md:w-2/3 flex flex-col items-center px-3">

        <article class="flex flex-col shadow my-4">

            <!-- Article Image -->
            <a href="#" class="hover:opacity-75">
                <img src="{{ $post->getThumbnail() }}">
            </a>
            <div class="bg-white flex flex-col justify-start p-6">
                <div class="flex gap-4">
                    @foreach ($post->categories as $category)
                        <a href="#"
                            class="text-blue-700 text-sm font-bold uppercase pb-4">{{ $category->title }}</a>
                    @endforeach
                </div>
                <h1 class="text-3xl font-bold hover:text-gray-700 pb-4">{{ $post->title }}</h1>
                <p href="#" class="text-sm pb-8">
                    By <a href="#" class="font-semibold hover:text-gray-800">{{ $post->user->name }}</a>,
                    Published on {{ $post->getFormattedDate() }}
                </p>
                {!! $post->body !!}
            </div>
        </article>



    </section>
    <x-sidebar />
</x-app-layout>
