<aside class="w-full md:w-1/3 flex flex-col items-center px-3">
    <div class="w-full bg-white shadow flex flex-col my-4 p-6">
        <h3 class="text-xl font-semibold mb-3">Các chuyên mục</h3>
        <ul>
            @foreach ($categories as $item)
                <a href="{{ route('byCategory', $item) }}"
                    class="text-semibold block py-2 px-3 rounded hover:bg-blue-600 hover:text-white {{ request('category') && request('category')->slug === $item->slug ? 'bg-blue-600 text-white' :'' }}">
                    {{ $item->title }} ({{ $item->total }})
                </a>
            @endforeach
        </ul>
    </div>


    {{-- <div class="w-full bg-white shadow flex flex-col my-4 p-6">
        <p class="text-xl font-semibold pb-5">About Us</p>
        <p class="pb-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas mattis est eu odio sagittis
            tristique. Vestibulum ut finibus leo. In hac habitasse platea dictumst.</p>
        <a href="#"
            class="w-full bg-blue-800 text-white font-bold text-sm uppercase rounded hover:bg-blue-700 flex items-center justify-center px-2 py-3 mt-4">
            Get to know us
        </a>
    </div> --}}


</aside>
