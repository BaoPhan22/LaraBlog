@php
    /** @var $post \Illuminate\Pagination\LengthAwarePaginator*/
@endphp

<x-app-layout meta-description='LaraBlog'>
    <!-- Posts Section -->
    <section class="w-full md:w-2/3 flex flex-col items-center px-3">
        @forelse ($data as $item)
            <x-post-item :post='$item'></x-post-item>
        @empty
            {{ __('Empty') }}
        @endforelse

        {{ $data->onEachSide(1)->links() }}
    </section>

    <x-sidebar />
</x-app-layout>
