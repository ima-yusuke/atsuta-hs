<x-app-layout>
    <div class="mt-20 py-12 flex max-md:flex-col gap-8 justify-center items-center">
        <div class="flex flex-col justify-center items-center shadow-xl text-center border-4 border-solid border-black bg-white w-[80%] md:w-[30%]">
            <a href="{{ route('ShowCategory') }}" class="w-full h-full hover:bg-black hover:text-white p-3">
                <div class="flex flex-col gap-2">
                    <p class="py-2"><i class="bi bi-view-stacked text-5xl"></i></p>
                    <p class="font-bold md:text-xl">カテゴリー追加</p>
                </div>
            </a>
        </div>
        <div class="flex flex-col justify-center items-center shadow-xl text-center border-4 border-solid border-black bg-white w-[80%] md:w-[30%]">
            <a href="{{ route('ShowContent') }}" class="w-full h-full hover:bg-black hover:text-white p-3">
                <div class="flex flex-col gap-2">
                    <p class="py-2"><i class="bi bi-collection-play text-5xl"></i></p>
                    <p class="font-bold md:text-xl">コンテンツ追加</p>
                </div>
            </a>
        </div>
    </div>
</x-app-layout>
