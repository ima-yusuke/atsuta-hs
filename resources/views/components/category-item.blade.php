<div id="category-list-{{ $category->id }}" class="category-item block md:w-full md:border-t md:border-s-8 border-solid border-gray-300" data-category-id="{{ $category->id }}">
    <p class="font-semibold category-item-title px-4 py-6 max-md:my-auto max-md:whitespace-nowrap md:border-b hover:bg-gray-200 cursor-pointer">{{ $category->name }}</p>

    {{-- 子カテゴリーがあればアコーディオン表示（最初は非表示） --}}
    @if($category->children->isNotEmpty())
        <div class="child-categories hidden md:w-full md:border-s-8 border-solid border-gray-300">
            @foreach($category->children as $child)
                @include('components.category-item', ['category' => $child])
            @endforeach
        </div>
    @endif
</div>
