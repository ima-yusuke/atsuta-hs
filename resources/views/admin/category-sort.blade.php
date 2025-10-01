@foreach ($categories as $category)
    <li class="category-item" data-id="{{ $category->id }}" data-parent-id="{{ $category->parent_id }}">
        <strong>{{ $category->name }}</strong>
        @if($category->children->isNotEmpty())
            <ul class="nested-category">
                @include('admin.category-sort', ['categories' => $category->children])
            </ul>
        @endif
    </li>
@endforeach
