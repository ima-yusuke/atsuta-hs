<x-app-layout>
    <div class="flex flex-col md:flex-row w-full pb-12">
        {{--カテゴリー選択--}}
        <div id="selected-category" class="hidden" data-selected-category="{{ session('select_category') }}"></div>
        <div class="side-nav md:fixed max-md:flex left-0 top-0 md:w-2/12 w-full md:h-[100dvh] h-20 md:mt-16 bg-white md:overflow-y-auto overflow-x-auto">
            <div id="category-list-0" class="sticky top-0 left-0 category-item flex flex-col items-center md:w-full mx-auto md:px-2 md:py-6 px-6 py-2 border-y border-solid bg-white hover:bg-gray-200 cursor-pointer" data-category-id="0">
                <p class="font-semibold max-md:my-auto max-md:whitespace-nowrap">新規登録</p>
            </div>
            @foreach($categories as $category)
                <div id="category-list-{{ $category->id }}" class="category-item flex flex-col items-center md:w-full mx-auto md:px-3 md:py-6 px-6 py-3 border-y border-solid hover:bg-gray-200 cursor-pointer" data-category-id="{{ $category->id }}">
                    <p class="font-semibold max-md:my-auto max-md:whitespace-nowrap">{{ $category->name }}</p>
                </div>
            @endforeach
        </div>
        <div class="max-md:hidden w-2/12"></div>
        {{--コンテンツ一覧表示--}}
        <div id="content-list" class="flex flex-col w-9/12 lg:w-8/12 md:mt-32 mt-12 mx-auto">
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
            {{--新規登録--}}
            <p id="category-title-new" class="hidden text-2xl font-bold text-start mb-8">動画コンテンツ追加</p>
            <div id="new-content" class="hidden md:px-10 md:py-3 px-2 py-1 bg-white border-t border-solid">
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
                                <label for="category_id" class="w-40 pe-2 text-gray-900 text-nowrap"><span class="md:hidden bg-red-500 w-14 my-auto me-2 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</span>カテゴリー名：</label>
                                <select name="category_id" id="category_id" class="lg:w-96 md:w-72 w-10/12 bg-gray-50 border border-gray-300 text-gray-900 rounded-xl focus:ring-blue-500 focus:border-blue-500 block max-md:mt-3 p-2">
                                    <option value="" selected disabled>カテゴリーを選択してください</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('category_id', 'add')
                            <p class="text-red-500 text-sm mt-2 max-md:text-center">※{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex flex-col w-full mt-3">
                            <p class="max-md:hidden bg-red-500 w-14 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</p>
                            <div class="flex flex-col w-full md:flex-row items-center mt-1">
                                <label for="name" class="w-40 pe-2 text-gray-900 text-nowrap"><span class="md:hidden bg-red-500 w-14 my-auto me-2 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</span>新規動画名：</label>
                                <input type="text" name="name" id="name" class="lg:w-96 md:w-72 w-10/12 bg-gray-50 border border-gray-300 text-gray-900 rounded-xl focus:ring-blue-500 focus:border-blue-500 block max-md:mt-3 p-2" placeholder="新規動画名" />
                            </div>
                            @error('name', 'add')
                            <p class="text-red-500 text-sm mt-2 max-md:text-center">※{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex flex-col w-full mt-3">
                            <p class="max-md:hidden bg-red-500 w-14 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</p>
                            <div class="flex flex-col w-full md:flex-row items-center mt-1">
                                <label for="url" class="w-40 pe-2 text-gray-900 text-nowrap"><span class="md:hidden bg-red-500 w-14 my-auto me-2 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</span>新規動画URL：</label>
                                <input type="text" name="url" id="url" class="lg:w-96 md:w-72 w-10/12 bg-gray-50 border border-gray-300 text-gray-900 rounded-xl focus:ring-blue-500 focus:border-blue-500 block max-md:mt-3 p-2" placeholder="新規動画URL" />
                            </div>
                            @error('url', 'add')
                            <p class="text-red-500 text-sm mt-2 max-md:text-center">※{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex flex-col w-full mt-3">
                            <p class="max-md:hidden bg-red-500 w-14 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</p>
                            <div class="flex flex-col w-full md:flex-row items-center mt-1">
                                <label for="img" class="w-40 pe-2 text-gray-900 text-nowrap"><span class="md:hidden bg-red-500 w-14 my-auto me-2 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</span>新規サムネイル画像：</label>
                                <input type="file" name="img" id="img" class="lg:w-96 md:w-72 w-10/12 max-md:mt-3 bg-gray-50 border border-gray-300 max-lg:text-sm max-md:text-xs text-gray-900 rounded-xl focus:ring-blue-500 focus:border-blue-500" />
                            </div>
                            @error('img', 'add')
                            <p class="text-red-500 text-sm mt-2 max-md:text-center">※{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="w-full md:mt-auto flex justify-center items-center max-md:my-5">
                        <button type="submit" class="border border-gray-900 h-full px-4 py-3 rounded-xl md:ms-auto md:me-10 md:mt-auto md:mb-4 me-3 hover:bg-gray-900 hover:text-white text-nowrap">追加</button>
                    </div>
                </form>
            </div>
            @php
                $lastCategoryId = null; // 直前のカテゴリーID
            @endphp
            {{--既存コンテンツ--}}
            <div id="sortable-content-list">
                @foreach ($contents as $content)
                    @if ($lastCategoryId !== $content->category_id)
                        <p id="category-title-{{ $content->category_id }}" class="hidden category-title text-2xl font-bold text-start mb-8">{{ $content->category->name }}</p>
                        @php
                            $lastCategoryId = $content->category_id;
                        @endphp
                    @endif
                    <div id="{{ $content->id }}" class="sortable-item" data-sort-category-id="{{ $content->category_id }}">
                        <button class="hidden video-contents w-full text-left mb-2 px-10 py-6 font-bold text-xl bg-white hover:bg-gray-200" data-content-category-id="{{ $content->category_id }}">
                            <span class="w-full">{{ $content->name }}</span>
                            <i class="bi bi-chevron-up hidden text-2xl md:me-10 self-center"></i>
                            <i class="bi bi-chevron-down text-2xl md:me-10 self-center"></i>
                        </button>
                        <div class="hidden content-details md:px-10 md:py-3 px-2 py-1 bg-white border-t border-solid flex-col @if ($errors->getBag('update' . $content->id)->has('name_' . $content->id) || $errors->getBag('update' . $content->id)->has('img') || $errors->getBag('update' . $content->id)->has('url_' . $content->id) || $errors->getBag('update' . $content->id)->has('category_id')) has-error @endif">
                            @if ($errors->getBag('update' . $content->id)->has('name_' . $content->id) || $errors->getBag('update' . $content->id)->has('img') || $errors->getBag('update' . $content->id)->has('url_' . $content->id) || $errors->getBag('update' . $content->id)->has('category_id'))
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
                                            <label for="category_name_{{ $content->category_id }}" class="w-40 pe-2 text-gray-900 text-nowrap"><span class="md:hidden bg-red-500 w-14 my-auto me-2 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</span>カテゴリー名：</label>
                                            <select name="category_id" id="category_id_{{ $content->category_id }}" class="lg:w-96 md:w-72 w-10/12 bg-gray-50 border border-gray-300 text-gray-900 rounded-xl focus:ring-blue-500 focus:border-blue-500 block max-md:mt-3 p-2">
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ $content->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('category_id', 'update' . $content->id)
                                        <p class="text-red-500 text-sm mt-2 max-md:text-center">※{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="flex flex-col w-full mt-3">
                                        <p class="max-md:hidden bg-red-500 w-14 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</p>
                                        <div class="flex flex-col w-full md:flex-row items-center mt-1">
                                            <label for="name_{{ $content->id }}" class="w-40 pe-2 text-gray-900 text-nowrap"><span class="md:hidden bg-red-500 w-14 my-auto me-2 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</span>動画名：</label>
                                            <input type="text" name="name_{{ $content->id }}" id="name_{{ $content->id }}" value="{{ old('name_' . $content->id, $content->name) }}" class="lg:w-96 md:w-72 w-10/12 bg-gray-50 border border-gray-300 text-gray-900 rounded-xl focus:ring-blue-500 focus:border-blue-500 block max-md:mt-3 p-2" />
                                        </div>
                                        @error('name_' . $content->id, 'update' . $content->id)
                                        <p class="text-red-500 text-sm mt-2 max-md:text-center">※{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="flex flex-col w-full mt-3">
                                        <p class="max-md:hidden bg-red-500 w-14 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</p>
                                        <div class="flex flex-col w-full md:flex-row items-center mt-1">
                                            <label for="url_{{ $content->id }}" class="w-40 pe-2 text-gray-900 text-nowrap"><span class="md:hidden bg-red-500 w-14 my-auto me-2 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</span>動画URL：</label>
                                            <input type="text" name="url_{{ $content->id }}" id="url_{{ $content->id }}" value="{{ old('url_' . $content->id, $content->url) }}" class="lg:w-96 md:w-72 w-10/12 bg-gray-50 border border-gray-300 text-gray-900 rounded-xl focus:ring-blue-500 focus:border-blue-500 block max-md:mt-3 p-2" />
                                        </div>
                                        @error('url_' . $content->id, 'update' . $content->id)
                                        <p class="text-red-500 text-sm mt-2 max-md:text-center">※{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="flex flex-col w-full mt-3">
                                        <p class="max-md:hidden bg-red-500 w-14 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</p>
                                        <div class="flex flex-col w-full md:flex-row items-center mt-1">
                                            <label for="img_{{ $content->id }}" class="w-40 pe-2 text-gray-900 text-nowrap"><span class="md:hidden bg-red-500 w-14 my-auto me-2 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</span>サムネイル画像：</label>
                                            <input type="file" name="img" id="img_{{ $content->id }}" class="lg:w-96 md:w-72 w-10/12 max-md:mt-3 bg-gray-50 border border-gray-300 max-lg:text-sm max-md:text-xs text-gray-900 rounded-xl focus:ring-blue-500 focus:border-blue-500" />
                                        </div>
                                        {{--画像プレビュー--}}
                                        <div class="flex flex-col md:flex-row gap-4 justify-center mt-3">
                                            {{-- 現在登録されている画像 --}}
                                            <div class="flex flex-col max-md:items-center w-full mt-3">
                                                <label class="text-gray-900 text-nowrap">現在の画像：</label>
                                                <img src="{{ asset($content->img) }}" alt="{{ $content->name }}" class="w-60" />
                                            </div>

                                            {{-- 選択した画像 --}}
                                            <div id="preview-container_{{ $content->id }}" class="flex-col max-md:items-center w-full mt-3 hidden">
                                                <label class="text-gray-900 text-nowrap">選択した画像：</label>
                                                <img id="preview_{{ $content->id }}" src="" alt="選択した画像" class="w-60" />
                                            </div>
                                        </div>
                                        @error('img', 'update' . $content->id)
                                        <p class="text-red-500 text-sm mt-2 max-md:text-center">※{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full md:mt-auto flex justify-center items-center max-md:my-5">
                                    <button type="button" data-action="{{ route('UpdateContent', $content->id) }}" onclick="submitForm({{ $content->id }}, this)" class="update-btn border border-gray-900 h-full px-4 py-3 rounded-xl md:ms-auto md:me-10 md:mt-auto md:mb-4 me-3 hover:bg-gray-900 hover:text-white text-nowrap">更新</button>
                                    <button type="button" data-action="{{ route('DeleteContent', $content->id) }}" onclick="submitForm({{ $content->id }}, this)" class="delete-btn border border-gray-900 h-full px-4 py-3 rounded-xl md:me-10 md:mt-auto md:mb-4 ms-3 hover:bg-gray-900 hover:text-white text-nowrap">削除</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <script>
        function submitForm(contentId, button) {
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
    </script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
    @vite('resources/js/admin/content.js')
</x-app-layout>
