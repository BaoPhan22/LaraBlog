@php
    $imagePath = $post->getThumbnail();
    $baseUrl = 'http://127.0.0.1:8000';
    
    // Xóa phần "/category" từ đường dẫn hình ảnh
    $cleanImagePath = str_replace('/category', '', $imagePath);
    
    // Tạo đường dẫn hình ảnh mới
    $newImageUrl = $baseUrl . '/' . $cleanImagePath;
    
@endphp
<article class="flex flex-col shadow my-4">
    <!-- Article Image -->
    <a href="{{ route('show', $post) }}" class="hover:opacity-75">
        <img src="{{ $newImageUrl }}">
    </a>
    <div class="bg-white flex flex-col justify-start p-6">

        <div class="flex gap-4">
            @foreach ($post->categories as $category)
                <a href="{{ route('byCategory', $category) }}"
                    class="text-blue-700 text-sm font-bold uppercase pb-4">{{ $category->title }}</a>
            @endforeach
        </div>
        <a href="{{ route('show', $post) }}" class="text-3xl font-bold hover:text-gray-700 pb-4">{{ $post->title }}</a>
        <p href="#" class="text-sm pb-3">
            By <a href="#" class="font-semibold hover:text-gray-800">{{ $post->user->name }}</a>, Published on
            {{ $post->getFormattedDate() }}
        </p>
        <a href="{{ route('show', $post) }}" class="pb-6">{!! $post->shortBody() !!}</a>
        <a href="{{ route('show', $post) }}" class="uppercase text-gray-800 hover:text-black">Continue Reading <i
                class="fas fa-arrow-right"></i></a>
    </div>
</article>
