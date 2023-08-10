@php
    /** @var $post \Illuminate\Pagination\LengthAwarePaginator*/
@endphp

<x-app-layout meta-description='LaraBlog'>
    <div class="container max-w-5xl mx-auto py-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- Latest Post --}}
            <div class="col-span-2">
                <h2 class="text-lg sm:text-xl font-bold text-blue-500 uppercase pb-1 border-b-2 border-blue-500 mb-3">
                    Bài viết mới nhất</h2>

                <x-post-item :post="$latestPost" />

            </div>

            <div class="col-span-1">
                <h2 class="text-lg sm:text-xl font-bold text-blue-500 uppercase pb-1 border-b-2 border-blue-500 mb-3">
                    Các bài viết phổ biến</h2>

                @foreach ($popularPosts as $post)
                    <div class="grid grid-cols-4 gap-2 mt-4">
                        <a href="{{ route('show', $post) }}">
                            <img src="{{ $post->getThumbnail() }}" alt="{{ $post->title }}">
                        </a>
                        <div class="col-span-3">
                            <a href="{{ route('show', $post) }}" class="font-semibold">{{ $post->title }}</a>
                            <div class="text-sm">
                                {{ $post->shortBody(10) }}
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
        {{-- Recommended post --}}
        <div>
            <div class="col-span-2">
                <h2 class="text-lg sm:text-xl font-bold text-blue-500 uppercase pb-1 border-b-2 border-blue-500 mb-3">
                    Dành cho bạn</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    @foreach ($recommendedPosts as $post)
                            <x-post-item :post="$post" />
                    @endforeach
                </div>
            </div>
        </div>
        <div>
            {{-- Latest Category --}}
            @foreach ($categories as $category)
                <div class="col-span-2">
                    <h2
                        class="text-lg sm:text-xl font-bold text-blue-500 uppercase pb-1 border-b-2 border-blue-500 mb-3">
                        {{ $category->title }} <a href="{{ route('byCategory', $category) }}"><i
                                class="fas fa-arrow-right"></i></a></h2>

                    <div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            @foreach ($category->posts()->limit(3)->get() as $post)
                                <div>
                                    <x-post-item :post="$post" />
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
