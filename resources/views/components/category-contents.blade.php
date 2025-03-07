{{--子カテゴリ--}}
@foreach($categories as $category)
    <div data-id="{{$category["id"]}}" data-name="{{$category["name"]}}" class="parent_id_{{$parent_id}} swiper-slide !hidden sub-category video-container !bg-white !flex !flex-col !items-center !pt-2 rounded-lg overflow-hidden gap-2">
        <aside class="w-full pl-4 flex flex-col items-start justify-center gap-1 border-b border-solid border-black">
            <p class="text-xs font-[Allura]">Category</p>
            <p class="text-xl">{{$category["name"]}}</p>
        </aside>
        <aside class="flex justify-center items-center h-full w-full">
            <img
                src="{{ asset($category['img'])}}"
                alt="Video Thumbnail"
                class="thumbnail object-cover w-[90%] h-[80%] cursor-pointer"
            >
        </aside>
    </div>

@endforeach

{{--コンテンツ--}}
@foreach($contents as $content)
    <div class="parent_id_{{$parent_id}} !hidden swiper-slide video-container sub-content relative overflow-hidden">--}}
        <img
            src="{{ asset($content['img'])}}"
            alt="Video Thumbnail"
            class="thumbnail object-cover m-auto w-full h-full cursor-pointer absolute top-0 left-0 z-10"
            onclick="playVideo(this)"
        >

        <!-- YouTube Player -->--}}
        <div class="youtubePlayer w-full h-auto" data-id="{{$content["id"]}}" data-url="{{$content['url']}}" style="display: none;"></div>

    </div>
@endforeach

{{--さらに子カテゴリがある場合、再帰的に呼び出し--}}
@foreach($categories as $category)
    @if($category->children->isNotEmpty())
        @include('components.category-contents', ['parent_id'=>$category->id,'categories' => $category->children,'contents'=>$category->contents])
    @endif
@endforeach
