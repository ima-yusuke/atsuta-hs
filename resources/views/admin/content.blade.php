<x-app-layout>
    <div class="flex flex-col md:flex-row w-full pb-12">
        {{--カテゴリー選択--}}
        <div id="clicked-category" class="hidden" data-clicked-category="{{ session('selected_accordion') ?? '0' }}"></div>
        <div class="side-nav md:fixed max-md:flex md:w-2/12 w-full md:min-h-[100dvh] h-20 md:pt-16 bg-white md:overflow-y-auto overflow-x-auto">
            <div id="category-list-new" class="category-item flex flex-col items-center md:w-full mx-auto md:px-2 md:py-6 px-6 py-2 md:border-y border-solid bg-white hover:bg-gray-200 cursor-pointer" data-category-id="category-new" data-category-name="カテゴリー新規登録">
                <p class="font-semibold max-md:my-auto max-md:whitespace-nowrap">カテゴリー新規登録</p>
            </div>
            <div id="content-list-new" class="category-item flex flex-col items-center md:w-full mx-auto md:px-2 md:py-6 px-6 py-2 md:border-y border-solid bg-white hover:bg-gray-200 cursor-pointer" data-category-id="content-new" data-category-name="動画コンテンツ新規登録">
                <p class="font-semibold max-md:my-auto max-md:whitespace-nowrap">コンテンツ新規登録</p>
            </div>
            <div id="category-list-0" class="category-item flex flex-col md:w-full mx-auto md:px-2 md:py-6 px-6 py-2 md:border-y border-solid bg-white hover:bg-gray-200 cursor-pointer" style="background-color: #d1e5ff" data-category-id="0" data-category-name="ルートカテゴリ">
                <p class="font-semibold max-md:my-auto max-md:whitespace-nowrap">ルートカテゴリ</p>
            </div>
            @foreach($categories as $category)
                @if($category->parent_id === 0)
                    @include('components.category-item', ['category' => $category])
                @endif
            @endforeach
        </div>
        <div class="max-md:hidden w-2/12"></div>
        {{--コンテンツ一覧表示--}}
        <div id="content-list" class="flex flex-col w-9/12 lg:w-8/12 md:mt-32 mt-12 mx-auto">
            {{--更新処理表示--}}
            @if (session('success'))
                <div id="success-alert" class="alert-area bg-green-100 border border-green-400 text-green-700 px-10 py-3 mb-4 rounded relative" role="alert">
                    <strong class="font-bold">{{ session('success') }}</strong>
                    <span class="close-button absolute top-0 bottom-0 right-0 px-10 py-3">
                        <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <title>Close</title>
                            <path d="M14.348 14.849a1 1 0 01-1.414 0L10 11.414l-2.933 2.935a1 1 0 01-1.414-1.414L8.586 10 5.651 7.066a1 1 0 011.414-1.414L10 8.586l2.933-2.934a1 1 0 111.414 1.414L11.414 10l2.935 2.933a1 1 0 010 1.415z"/>
                        </svg>
                    </span>
                </div>
            @endif
            @if (session('error'))
                <div id="error-alert" class="alert-area bg-red-100 border border-red-400 text-red-700 px-10 py-3 rounded relative" role="alert">
                    <strong class="font-bold">{{ session('error') }}</strong>
                    <span class="close-button absolute top-0 bottom-0 right-0 px-10 py-3">
                        <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <title>Close</title>
                            <path d="M14.348 14.849a1 1 0 01-1.414 0L10 11.414l-2.933 2.935a1 1 0 01-1.414-1.414L8.586 10 5.651 7.066a1 1 0 011.414-1.414L10 8.586l2.933-2.934a1 1 0 111.414 1.414L11.414 10l2.935 2.933a1 1 0 010 1.415z"/>
                        </svg>
                    </span>
                </div>
            @endif
            {{--カテゴリー新規登録--}}
            <p id="category-title-new" class="hidden text-2xl font-bold text-start mb-8">カテゴリー新規登録</p>
            <div id="category-new" class="md:px-10 md:py-3 px-2 py-1 bg-white border-t border-solid">
                @if ($errors->add->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 my-4 rounded relative">
                        <strong class="font-bold">入力された内容にエラーがあります。</strong>
                    </div>
                @endif
                <form action="{{ route('AddCategory') }}" method="POST" enctype="multipart/form-data" class="flex max-md:flex-col w-full">
                    @csrf
                    <div class="flex flex-col w-full pb-4">
                        <div class="flex flex-col w-full mt-3">
                            <p class="max-md:hidden bg-red-500 w-14 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</p>
                            <div class="flex flex-col w-full md:flex-row items-center mt-1">
                                <label for="parent_id" class="w-40 pe-2 text-gray-900 text-nowrap"><span class="md:hidden bg-red-500 w-14 my-auto me-2 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</span>親カテゴリー分類：</label>
                                <select name="parent_id" id="parent_id" class="lg:w-96 md:w-72 w-10/12 bg-gray-50 border border-gray-300 text-gray-900 rounded-xl focus:ring-blue-500 focus:border-blue-500 block max-md:mt-3 p-2">
                                    <option value="" selected disabled>親カテゴリーを選択してください</option>
                                    <option value="0">ルートカテゴリ</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('parent_id', 'add_category')
                            <p class="text-red-500 text-sm mt-2 max-md:text-center">※{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex flex-col w-full mt-3">
                            <p class="max-md:hidden bg-red-500 w-14 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</p>
                            <div class="flex flex-col w-full md:flex-row items-center mt-1">
                                <label for="category_name" class="w-40 pe-2 text-gray-900 text-nowrap"><span class="md:hidden bg-red-500 w-14 my-auto me-2 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</span>新規カテゴリー名：</label>
                                <input type="text" name="category_name" id="category_name" class="lg:w-96 md:w-72 w-10/12 bg-gray-50 border border-gray-300 text-gray-900 rounded-xl focus:ring-blue-500 focus:border-blue-500 block max-md:mt-3 p-2" placeholder="新規カテゴリー名" value="{{ old('category_name') }}" />
                            </div>
                            @error('category_name', 'add_category')
                            <p class="text-red-500 text-sm mt-2 max-md:text-center">※{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex flex-col w-full mt-3">
                            <p class="max-md:hidden bg-red-500 w-14 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</p>
                            <div class="flex flex-col md:flex-row items-center mt-1">
                                <label for="category_img_new" class="w-40 pe-2 text-gray-900 text-nowrap">
                                    <span class="md:hidden bg-red-500 w-14 my-auto me-2 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</span>
                                    新規カテゴリー画像：
                                </label>
                                <input type="file" name="category_img_new" id="category_img_new"
                                       class="lg:w-96 md:w-72 w-10/12 max-md:mt-3 bg-gray-50 border border-gray-300 max-lg:text-sm max-md:text-xs text-gray-900 rounded-xl focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            {{-- 新規カテゴリーの選択した画像 --}}
                            <div id="preview-container_category_new" class="flex-col max-md:items-center w-full mt-3 hidden">
                                <label class="text-gray-900 text-nowrap">選択した画像：</label>
                                <img id="preview_category_new" src="" alt="選択した画像" class="w-60" />
                            </div>
                            @error('category_img_new', 'add_category')
                            <p class="text-red-500 text-sm mt-2 max-md:text-center">※{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="w-full md:mt-auto flex justify-center items-center max-md:my-5">
                        <button type="submit" class="border border-gray-900 h-full px-4 py-3 rounded-xl md:ms-auto md:me-10 md:mt-auto md:mb-4 me-3 hover:bg-gray-900 hover:text-white text-nowrap">追加</button>
                    </div>
                </form>
            </div>
            {{--コンテンツ新規登録--}}
            <p id="content-title-new" class="hidden text-2xl font-bold text-start mb-8">動画コンテンツ新規登録</p>
            <div id="content-new" class="hidden md:px-10 md:py-3 px-2 py-1 bg-white border-t border-solid">
                @if ($errors->add->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 my-4 rounded relative">
                        <strong class="font-bold">入力された内容にエラーがあります。</strong>
                    </div>
                @endif
                <form action="{{ route('AddContent') }}" method="POST" enctype="multipart/form-data" class="flex max-md:flex-col w-full">
                    @csrf
                    <div class="flex flex-col w-full pb-4">
                        <div class="flex flex-col w-full mt-3">
                            <p class="max-md:hidden bg-red-500 w-14 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</p>
                            <div class="flex flex-col w-full md:flex-row items-center mt-1">
                                <label for="category_id" class="w-40 pe-2 text-gray-900 text-nowrap"><span class="md:hidden bg-red-500 w-14 my-auto me-2 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</span>カテゴリー分類：</label>
                                <select name="category_id" id="category_id" class="lg:w-96 md:w-72 w-10/12 bg-gray-50 border border-gray-300 text-gray-900 rounded-xl focus:ring-blue-500 focus:border-blue-500 block max-md:mt-3 p-2">
                                    <option value="" selected disabled>カテゴリーを選択してください</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('category_id', 'add_content')
                            <p class="text-red-500 text-sm mt-2 max-md:text-center">※{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex flex-col w-full mt-3">
                            <p class="max-md:hidden bg-red-500 w-14 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</p>
                            <div class="flex flex-col w-full md:flex-row items-center mt-1">
                                <label for="content_name" class="w-40 pe-2 text-gray-900 text-nowrap"><span class="md:hidden bg-red-500 w-14 my-auto me-2 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</span>新規動画名：</label>
                                <input type="text" name="content_name" id="content_name" class="lg:w-96 md:w-72 w-10/12 bg-gray-50 border border-gray-300 text-gray-900 rounded-xl focus:ring-blue-500 focus:border-blue-500 block max-md:mt-3 p-2" placeholder="新規動画名" />
                            </div>
                            @error('content_name', 'add_content')
                            <p class="text-red-500 text-sm mt-2 max-md:text-center">※{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex flex-col w-full mt-3">
                            <p class="max-md:hidden bg-red-500 w-14 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</p>
                            <div class="flex flex-col w-full md:flex-row items-center mt-1">
                                <label for="content_url" class="w-40 pe-2 text-gray-900 text-nowrap"><span class="md:hidden bg-red-500 w-14 my-auto me-2 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</span>新規動画URL：</label>
                                <input type="text" name="content_url" id="content_url" class="lg:w-96 md:w-72 w-10/12 bg-gray-50 border border-gray-300 text-gray-900 rounded-xl focus:ring-blue-500 focus:border-blue-500 block max-md:mt-3 p-2" placeholder="新規動画URL" />
                            </div>
                            @error('content_url', 'add_content')
                            <p class="text-red-500 text-sm mt-2 max-md:text-center">※{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex flex-col w-full mt-3">
                            <p class="max-md:hidden bg-red-500 w-14 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</p>
                            <div class="flex flex-col w-full md:flex-row items-center mt-1">
                                <label for="content_img_new" class="w-40 pe-2 text-gray-900 text-nowrap">
                                    <span class="md:hidden bg-red-500 w-14 my-auto me-2 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</span>
                                    新規サムネイル画像：
                                </label>
                                <input type="file" name="content_img_new" id="content_img_new" class="lg:w-96 md:w-72 w-10/12 max-md:mt-3 bg-gray-50 border border-gray-300 max-lg:text-sm max-md:text-xs text-gray-900 rounded-xl focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            {{-- 新規コンテンツの選択した画像 --}}
                            <div id="preview-container_content_new" class="flex-col max-md:items-center w-full mt-3 hidden">
                                <label class="text-gray-900 text-nowrap">選択した画像：</label>
                                <img id="preview_content_new" src="" alt="選択した画像" class="w-60" />
                            </div>
                            @error('content_img_new', 'add_content')
                            <p class="text-red-500 text-sm mt-2 max-md:text-center">※{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="w-full md:mt-auto flex justify-center items-center max-md:my-5">
                        <button type="submit" class="border border-gray-900 h-full px-4 py-3 rounded-xl md:ms-auto md:me-10 md:mt-auto md:mb-4 me-3 hover:bg-gray-900 hover:text-white text-nowrap">追加</button>
                    </div>
                </form>
            </div>
            {{--既存コンテンツ--}}
            <p id="category-title" class="text-2xl font-bold text-start mb-8"></p>
            <div id="sortable-category-list">
                {{--カテゴリー一覧--}}
                @foreach($categories as $category)
                    <div id="{{ $category->id }}" class="sortable-item" data-sort-parent-id="{{ $category->parent_id }}">
                        <button class="hidden nested-category w-full text-left mb-2 px-10 py-6 font-bold text-xl bg-gray-300 hover:bg-gray-200" data-parent-category-id="{{ $category->parent_id }}">
                            <span class="w-full">{{ $category->name }}</span>
                            <i class="bi bi-chevron-up opened hidden text-2xl md:me-10 self-center"></i>
                            <i class="bi bi-chevron-down closed text-2xl md:me-10 self-center"></i>
                        </button>
                        <div class="hidden category-details md:px-10 md:py-3 px-2 py-1 bg-white border-t border-solid flex-col @if ($errors->getBag('update_category_' . $category->id)->has('parent_id') || $errors->getBag('update_category_' . $category->id)->has('category_name_' . $category->id) || $errors->getBag('update_category_' . $category->id)->has('category_img_' . $category->id)) has-error @endif">
                            @if ($errors->getBag('update_category_' . $category->id)->has('parent_id') || $errors->getBag('update_category_' . $category->id)->has('category_name_' . $category->id) || $errors->getBag('update_category_' . $category->id)->has('category_img_' . $category->id))
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 my-4 rounded relative">
                                    <strong class="font-bold">入力された内容にエラーがあります。</strong>
                                </div>
                            @endif
                            <form id="category-form-{{ $category->id }}" method="POST" enctype="multipart/form-data" class="flex max-md:flex-col w-full">
                                @csrf
                                <div class="flex flex-col w-full pb-4">
                                    <div class="flex flex-col w-full mt-3">
                                        <p class="max-md:hidden bg-red-500 w-14 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</p>
                                        <div class="flex flex-col w-full md:flex-row items-center mt-1">
                                            <label for="parent_id_{{ $category->id }}" class="w-40 pe-2 text-gray-900 text-nowrap">
                                                <span class="md:hidden bg-red-500 w-14 my-auto me-2 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</span>
                                                親カテゴリー分類：
                                            </label>
                                            <select name="parent_id" id="parent_id_{{ $category->id }}" class="lg:w-96 md:w-72 w-10/12 bg-gray-50 border border-gray-300 text-gray-900 rounded-xl focus:ring-blue-500 focus:border-blue-500 block max-md:mt-3 p-2">
                                                <option value="0" {{ $category->parent_id == 0 ? 'selected' : '' }}>ルートカテゴリ</option>
                                                @foreach($categories as $parentCategory)
                                                    <option value="{{ $parentCategory->id }}" {{ $category->parent_id == $parentCategory->id ? 'selected' : '' }}>
                                                        {{ $parentCategory->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('parent_id', 'update_category_' . $category->id)
                                        <p class="text-red-500 text-sm mt-2 max-md:text-center">※{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="flex flex-col w-full mt-3">
                                        <p class="max-md:hidden bg-red-500 w-14 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</p>
                                        <div class="flex flex-col w-full md:flex-row items-center mt-1">
                                            <label for="category_name_{{ $category->id }}" class="w-40 pe-2 text-gray-900 text-nowrap"><span class="md:hidden bg-red-500 w-14 my-auto me-2 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</span>カテゴリー名：</label>
                                            <input type="text" name="category_name_{{ $category->id }}" id="category_name_{{ $category->id }}" value="{{ old('category_name_' . $category->id, $category->name) }}" class="lg:w-96 md:w-72 w-10/12 bg-gray-50 border border-gray-300 text-gray-900 rounded-xl focus:ring-blue-500 focus:border-blue-500 block max-md:mt-3 p-2" />
                                        </div>
                                        @error('category_name_' . $category->id, 'update_category_' . $category->id)
                                        <p class="text-red-500 text-sm mt-2 max-md:text-center">※{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="flex flex-col w-full mt-3">
                                        <p class="max-md:hidden bg-red-500 w-14 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</p>
                                        <div class="flex flex-col w-full md:flex-row items-center mt-1">
                                            <label for="category_img_{{ $category->id }}" class="w-40 pe-2 text-gray-900 text-nowrap"><span class="md:hidden bg-red-500 w-14 my-auto me-2 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</span>カテゴリー画像：</label>
                                            <input type="file" name="category_img_{{ $category->id }}" id="category_img_{{ $category->id }}" class="lg:w-96 md:w-72 w-10/12 max-md:mt-3 bg-gray-50 border border-gray-300 max-lg:text-sm max-md:text-xs text-gray-900 rounded-xl focus:ring-blue-500 focus:border-blue-500" />
                                        </div>
                                        @error('category_img_' . $category->id, 'update_category_' . $category->id)
                                        <p class="text-red-500 text-sm mt-2 max-md:text-center">※{{ $message }}</p>
                                        @enderror
                                        {{--画像プレビュー--}}
                                        <div class="flex flex-col md:flex-row gap-4 justify-center mt-3">
                                            {{-- 現在登録されている画像 --}}
                                            <div class="flex flex-col max-md:items-center w-full mt-3">
                                                <label class="text-gray-900 text-nowrap">現在の画像：</label>
                                                <img src="{{ asset($category->img) }}" alt="{{ $category->name }}" class="w-60" />
                                            </div>

                                            {{-- 選択した画像 --}}
                                            <div id="preview-container_category_{{ $category->id }}" class="flex-col max-md:items-center w-full mt-3 hidden">
                                                <label class="text-gray-900 text-nowrap">選択した画像：</label>
                                                <img id="preview_category_{{ $category->id }}" src="" alt="選択した画像" class="w-60" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full md:mt-auto flex justify-center items-center max-md:my-5">
                                    <button type="button" data-action="{{ route('UpdateCategory', $category->id) }}" onclick="submitCategoryForm({{ $category->id }}, this)" class="update-btn border border-gray-900 h-full px-4 py-3 rounded-xl md:ms-auto md:me-10 md:mt-auto md:mb-4 me-3 hover:bg-gray-900 hover:text-white text-nowrap">更新</button>
                                    <button type="button" data-action="{{ route('DeleteCategory', $category->id) }}" onclick="submitCategoryForm({{ $category->id }}, this)" class="delete-btn border border-gray-900 h-full px-4 py-3 rounded-xl md:me-10 md:mt-auto md:mb-4 ms-3 hover:bg-gray-900 hover:text-white text-nowrap">削除</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            <div id="sortable-content-list">
                {{--コンテンツ一覧--}}
                @foreach ($contents as $content)
                    <div id="{{ $content->id }}" class="sortable-item" data-sort-category-id="{{ $content->category_id }}">
                        <button class="hidden video-contents w-full text-left mb-2 px-10 py-6 font-bold text-xl bg-white hover:bg-gray-200" data-content-category-id="{{ $content->category_id }}">
                            <span class="w-full">{{ $content->name }}</span>
                            <i class="bi bi-chevron-up opened hidden text-2xl md:me-10 self-center"></i>
                            <i class="bi bi-chevron-down closed text-2xl md:me-10 self-center"></i>
                        </button>
                        <div class="hidden content-details md:px-10 md:py-3 px-2 py-1 bg-white border-t border-solid flex-col @if ($errors->getBag('update_content_' . $content->id)->has('content_name_' . $content->id) || $errors->getBag('update_content_' . $content->id)->has('content_img_' . $content->id) || $errors->getBag('update_content_' . $content->id)->has('content_url_' . $content->id) || $errors->getBag('update_content_' . $content->id)->has('category_id')) has-error @endif">
                            @if ($errors->getBag('update_content_' . $content->id)->has('content_name_' . $content->id) || $errors->getBag('update_content_' . $content->id)->has('content_img_' . $content->id) || $errors->getBag('update_content_' . $content->id)->has('content_url_' . $content->id) || $errors->getBag('update_content_' . $content->id)->has('category_id'))
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 my-4 rounded relative">
                                    <strong class="font-bold">入力された内容にエラーがあります。</strong>
                                </div>
                            @endif
                            <form id="content-form-{{ $content->id }}" method="POST" enctype="multipart/form-data" class="flex max-md:flex-col w-full h-full">
                                @csrf
                                <div class="flex flex-col w-full pb-4">
                                    <div class="flex flex-col w-full mt-3">
                                        <p class="max-md:hidden bg-red-500 w-14 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</p>
                                        <div class="flex flex-col w-full md:flex-row items-center mt-1">
                                            <label for="category_id" class="w-40 pe-2 text-gray-900 text-nowrap"><span class="md:hidden bg-red-500 w-14 my-auto me-2 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</span>カテゴリー名：</label>
                                            <select name="category_id" id="category_id_{{ $content->category_id }}" class="lg:w-96 md:w-72 w-10/12 bg-gray-50 border border-gray-300 text-gray-900 rounded-xl focus:ring-blue-500 focus:border-blue-500 block max-md:mt-3 p-2">

                                            @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ $content->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('category_id', 'update_content_' . $content->id)
                                        <p class="text-red-500 text-sm mt-2 max-md:text-center">※{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="flex flex-col w-full mt-3">
                                        <p class="max-md:hidden bg-red-500 w-14 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</p>
                                        <div class="flex flex-col w-full md:flex-row items-center mt-1">
                                            <label for="content_name_{{ $content->id }}" class="w-40 pe-2 text-gray-900 text-nowrap"><span class="md:hidden bg-red-500 w-14 my-auto me-2 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</span>動画名：</label>
                                            <input type="text" name="content_name_{{ $content->id }}" id="content_name_{{ $content->id }}" value="{{ old('content_name_' . $content->id, $content->name) }}" class="lg:w-96 md:w-72 w-10/12 bg-gray-50 border border-gray-300 text-gray-900 rounded-xl focus:ring-blue-500 focus:border-blue-500 block max-md:mt-3 p-2" />
                                        </div>
                                        @error('content_name_' . $content->id, 'update_content_' . $content->id)
                                        <p class="text-red-500 text-sm mt-2 max-md:text-center">※{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="flex flex-col w-full mt-3">
                                        <p class="max-md:hidden bg-red-500 w-14 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</p>
                                        <div class="flex flex-col w-full md:flex-row items-center mt-1">
                                            <label for="content_url_{{ $content->id }}" class="w-40 pe-2 text-gray-900 text-nowrap"><span class="md:hidden bg-red-500 w-14 my-auto me-2 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</span>動画URL：</label>
                                            <input type="text" name="content_url_{{ $content->id }}" id="content_url_{{ $content->id }}" value="{{ old('content_url_' . $content->id, $content->url) }}" class="lg:w-96 md:w-72 w-10/12 bg-gray-50 border border-gray-300 text-gray-900 rounded-xl focus:ring-blue-500 focus:border-blue-500 block max-md:mt-3 p-2" />
                                        </div>
                                        @error('content_url_' . $content->id, 'update_content_' . $content->id)
                                        <p class="text-red-500 text-sm mt-2 max-md:text-center">※{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="flex flex-col w-full mt-3">
                                        <p class="max-md:hidden bg-red-500 w-14 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</p>
                                        <div class="flex flex-col w-full md:flex-row items-center mt-1">
                                            <label for="content_img_{{ $content->id }}" class="w-40 pe-2 text-gray-900 text-nowrap"><span class="md:hidden bg-red-500 w-14 my-auto me-2 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</span>サムネイル画像：</label>
                                            <input type="file" name="content_img_{{ $content->id }}" id="content_img_{{ $content->id }}" class="lg:w-96 md:w-72 w-10/12 max-md:mt-3 bg-gray-50 border border-gray-300 max-lg:text-sm max-md:text-xs text-gray-900 rounded-xl focus:ring-blue-500 focus:border-blue-500" />
                                        </div>
                                        @error('content_img_' . $content->id, 'update_content_' . $content->id)
                                        <p class="text-red-500 text-sm mt-2 max-md:text-center">※{{ $message }}</p>
                                        @enderror
                                        {{--画像プレビュー--}}
                                        <div class="flex flex-col md:flex-row gap-4 justify-center mt-3">
                                            {{-- 現在登録されている画像 --}}
                                            <div class="flex flex-col max-md:items-center w-full mt-3">
                                                <label class="text-gray-900 text-nowrap">現在の画像：</label>
                                                <img src="{{ asset($content->img) }}" alt="{{ $content->name }}" class="w-60" />
                                            </div>

                                            {{-- 選択した画像 --}}
                                            <div id="preview-container_content_{{ $content->id }}" class="flex-col max-md:items-center w-full mt-3 hidden">
                                                <label class="text-gray-900 text-nowrap">選択した画像：</label>
                                                <img id="preview_content_{{ $content->id }}" src="" alt="選択した画像" class="w-60" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full md:mt-auto flex justify-center items-center max-md:my-5">
                                    <button type="button" data-action="{{ route('UpdateContent', $content->id) }}" onclick="submitContentForm({{ $content->id }}, this)" class="update-btn border border-gray-900 h-full px-4 py-3 rounded-xl md:ms-auto md:me-10 md:mt-auto md:mb-4 me-3 hover:bg-gray-900 hover:text-white text-nowrap">更新</button>
                                    <button type="button" data-action="{{ route('DeleteContent', $content->id) }}" onclick="submitContentForm({{ $content->id }}, this)" class="delete-btn border border-gray-900 h-full px-4 py-3 rounded-xl md:me-10 md:mt-auto md:mb-4 ms-3 hover:bg-gray-900 hover:text-white text-nowrap">削除</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <script>
        function submitContentForm(contentId, button) {
            if (button.textContent.trim() === '削除' && !confirm('本当に削除しますか？\nこの操作は取り消せません。')) {
                return; // キャンセルした場合は処理を中断
            }
            const form = document.getElementById(`content-form-${contentId}`);
            form.action = button.getAttribute('data-action');
            if (button.textContent.trim() === '削除') {
                form.method = 'POST';
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);
            }
            form.submit();
        }

        function submitCategoryForm(categoryId, button) {
            if (button.textContent.trim() === '削除' && !confirm('本当に削除しますか？\nこの操作は取り消せません。')) {
                return; // キャンセルした場合は処理を中断
            }
            const form = document.getElementById(`category-form-${categoryId}`);
            form.action = button.getAttribute('data-action');
            if (button.textContent.trim() === '削除') {
                form.method = 'POST';
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);
            }
            form.submit();
        }
    </script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
    @vite('resources/js/admin/content.js')
</x-app-layout>
