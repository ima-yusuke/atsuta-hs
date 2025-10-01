<x-app-layout>
    <div class="flex flex-col justify-center items-center w-full py-12">
        <p class="w-11/12 lg:w-10/12 text-2xl font-bold md:mt-20 mt-8 text-start">カテゴリー・コンテンツ並び替え</p>
        {{-- カテゴリーとコンテンツの並び替え --}}
        <ul id="categories" class="w-11/12 lg:w-10/12 mt-8">
            {{-- カテゴリー --}}
            @foreach ($categories as $category)
                <li class="category-item w-full px-10 py-6 mt-4 text-xl bg-white border border-solid border-gray-300 rounded" data-id="{{ $category->id }}" data-parent-id="{{ $category->parent_id ?? 'null' }}">
                    <strong class="font-bold">{{ $category->name }}</strong>
                    @if($category->children->isNotEmpty())
                        <ul class="nested-category">
                            {{-- 子カテゴリー --}}
                            @include('admin.category-sort', ['categories' => $category->children])
                        </ul>
                    @endif
                    <ul class="content-list">
                        {{-- コンテンツ --}}
                        @foreach ($category->contents as $content)
                            <li class="content-item w-full px-10 py-6 mt-4 text-xl bg-white border border-solid border-gray-300 rounded" data-id="{{ $content->id }}" data-category-id="{{ $category->id }}">
                                {{ $content->name }}
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
    </div>
    <script src="//cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
    @vite('resources/js/admin/sort.js')
</x-app-layout>
