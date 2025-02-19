<x-app-layout>
    <div class="flex flex-col justify-center items-center w-full py-12">
        <p class="w-11/12 lg:w-10/12 text-2xl font-bold md:mt-20 mt-8 text-start">カテゴリー追加</p>
        <!-- カテゴリー一覧表示 -->
        <div id="category-list" class="flex flex-col w-11/12 lg:w-10/12 mt-8">
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
            <div id="sortable-category-list">
                @foreach ($categories as $category)
                    <div id="{{ $category->id }}" class="sortable-item">
                        <button class="categories flex w-full text-left mb-2 px-10 py-6 font-bold text-xl bg-white hover:bg-gray-200" data-category-id="{{ $category->id }}">
                            <span class="w-full">{{ $category->name }}</span>
                            <i class="bi bi-chevron-up hidden text-2xl md:me-10 self-center"></i>
                            <i class="bi bi-chevron-down text-2xl md:me-10 self-center"></i>
                        </button>
                        <div class="hidden md:px-10 md:py-3 px-2 py-1 bg-white border-t border-solid flex-col @if ($errors->getBag('update' . $category->id)->has('name_' . $category->id) || $errors->getBag('update' . $category->id)->has('img')) has-error @endif">
                            @if ($errors->getBag('update' . $category->id)->has('name_' . $category->id) || $errors->getBag('update' . $category->id)->has('img'))
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 my-4 rounded relative">
                                    <strong class="font-bold">入力された内容にエラーがあります。</strong>
                                </div>
                            @endif
                            <form id="category-form-{{ $category->id }}" method="POST" enctype="multipart/form-data" class="flex max-md:flex-col w-full h-full">
                                @csrf
                                <div class="flex flex-col w-full pb-4">
                                    <div class="flex flex-col w-full mt-3">
                                        <p class="max-md:hidden bg-red-500 w-14 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</p>
                                        <div class="flex flex-col w-full md:flex-row items-center mt-1">
                                            <label for="name_{{ $category->id }}" class="w-48 pe-2 text-gray-900 text-nowrap"><span class="md:hidden bg-red-500 w-14 my-auto me-2 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</span>カテゴリー名：</label>
                                            <input type="text" name="name_{{ $category->id }}" id="name_{{ $category->id }}" value="{{ old('name_' . $category->id, $category->name) }}" class="lg:w-96 md:w-72 w-9/12 bg-gray-50 border border-gray-300 text-gray-900 rounded-xl focus:ring-blue-500 focus:border-blue-500 block max-md:mt-3 p-2" />
                                        </div>
                                        @error('name_' . $category->id, 'update' . $category->id)
                                        <p class="text-red-500 text-sm mt-2 max-md:text-center">※{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="flex flex-col max-md:items-center w-full mt-12">
                                        <p class="max-md:hidden bg-red-500 w-14 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</p>
                                        <div class="flex flex-col w-full md:flex-row items-center mt-1">
                                            <label for="img_{{ $category->id }}" class="w-48 pe-2 text-gray-900 text-nowrap"><span class="md:hidden bg-red-500 w-14 my-auto me-2 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</span>カテゴリー画像：</label>
                                            <input type="file" name="img" id="img_{{ $category->id }}" class="lg:w-96 md:w-72 w-10/12 max-md:mt-3 bg-gray-50 border border-gray-300 max-lg:text-sm max-md:text-xs text-gray-900 rounded-xl focus:ring-blue-500 focus:border-blue-500" />
                                        </div>
                                        {{-- 画像プレビュー --}}
                                        <div class="flex flex-col md:flex-row gap-4 justify-center mt-3">
                                            {{-- 現在登録されている画像 --}}
                                            <div class="flex flex-col max-md:items-center w-full mt-3">
                                                <label class="text-gray-900 text-nowrap">現在の画像：</label>
                                                <img src="{{ asset($category->img) }}" alt="{{ $category->name }}" class="w-60" />
                                            </div>

                                            {{-- 選択した画像 --}}
                                            <div id="preview-container_{{ $category->id }}" class="flex-col max-md:items-center w-full mt-3 hidden">
                                                <label class="text-gray-900 text-nowrap">選択した画像：</label>
                                                <img id="preview_{{ $category->id }}" src="" alt="選択した画像" class="w-60" />
                                            </div>
                                        </div>
                                        @error('img', 'update' . $category->id)
                                        <p class="text-red-500 text-sm mt-2 max-md:text-center">※{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full h-full md:mt-auto flex justify-center items-center max-md:my-5">
                                    <button type="button" data-action="{{ route('UpdateCategory', $category->id) }}" onclick="submitForm({{ $category->id }}, this)" class="update-btn border border-gray-900 h-full px-4 py-3 rounded-xl md:ms-auto md:me-10 md:mt-auto md:mb-4 me-3 hover:bg-gray-900 hover:text-white text-nowrap">更新</button>
                                    <button type="button" data-action="{{ route('DeleteCategory', $category->id) }}" onclick="submitForm({{ $category->id }}, this)" class="delete-btn border border-gray-900 h-full px-4 py-3 rounded-xl md:me-10 md:mt-auto md:mb-4 ms-3 hover:bg-gray-900 hover:text-white text-nowrap">削除</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        {{--新規カテゴリー追加--}}
        <div class="flex flex-col w-11/12 lg:w-10/12 border border-solid border-gray-200 bg-white md:px-10 md:py-3 px-2 py-1">
            <p @if($errors->add->any()) id="error-new-category" @endif class="text-xl font-bold max-md:ps-8 pt-5">新規カテゴリー追加</p>
            @if ($errors->add->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 my-4 rounded relative">
                    <strong class="font-bold">入力された内容にエラーがあります。</strong>
                </div>
            @endif
            <form action="{{ route('AddCategory') }}" method="POST" enctype="multipart/form-data" class="flex max-md:flex-col">
                @csrf
                <div class="flex flex-col w-full pt-8 pb-4">
                    <div class="flex flex-col w-full">
                        <p class="max-md:hidden bg-red-500 w-14 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</p>
                        <div class="flex flex-col w-full md:flex-row items-center mt-1">
                            <label for="category" class="w-48 pe-2 text-gray-900 text-nowrap"><span class="md:hidden bg-red-500 w-14 my-auto me-2 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</span>新規カテゴリー名：</label>
                            <input type="text" name="name" id="category" class="lg:w-96 md:w-72 w-9/12 bg-gray-50 border border-gray-300 text-gray-900 rounded-xl focus:ring-blue-500 focus:border-blue-500 block max-md:mt-3 p-2" placeholder="新規カテゴリー名" value="{{ old('name') }}" />
                        </div>
                        @error('name', 'add')
                        <p class="text-red-500 text-sm mt-2 max-md:text-center">※{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col w-full mt-12">
                        <p class="max-md:hidden bg-red-500 w-14 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</p>
                        <div class="flex flex-col md:flex-row items-center mt-1">
                            <label for="img" class="w-48 pe-2 text-gray-900 text-nowrap"><span class="md:hidden bg-red-500 w-14 my-auto me-2 px-2 py-[2px] text-xs text-white text-nowrap text-center rounded-xl">必須</span>新規カテゴリー画像：</label>
                            <input type="file" name="img" id="img" class="lg:w-96 md:w-72 w-10/12 max-md:mt-3 bg-gray-50 border border-gray-300 max-lg:text-sm max-md:text-xs text-gray-900 rounded-xl focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        @error('img', 'add')
                        <p class="text-red-500 text-sm mt-2 max-md:text-center">※{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="border border-gray-900 h-full px-4 py-3 rounded-xl md:ms-auto md:me-10 md:mt-auto md:mb-4 max-md:mx-auto max-md:my-5 hover:bg-gray-900 hover:text-white text-nowrap">追加</button>
            </form>
        </div>
    </div>
    <script>
        // フォームの更新削除切り替え
        function submitForm(categoryId, button) {
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
    @vite('resources/js/admin/category.js')
</x-app-layout>
