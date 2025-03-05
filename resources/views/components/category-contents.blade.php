{{--子カテゴリ--}}
@foreach($categories as $category)
    <div data-id="{{$category["id"]}}" class="parent_id_{{$parent_id}} swiper-slide !hidden sub-category video-container relative overflow-hidden">--}}
        <img
            src="{{ asset($category['img'])}}"
            alt="Video Thumbnail"
            class="thumbnail object-cover m-auto w-full h-full cursor-pointer absolute top-0 left-0 z-10"
        >
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
