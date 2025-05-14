import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';
import 'swiper/css/pagination';

// カテゴリー（トップ画面メニュー）
const CategoryContainer  = document.getElementById("category_container");
const CategorySlide = document.getElementsByClassName("category-slide");

// コンテンツ
const ContentsContainer = document.getElementById("contents_container");
let CategoryTitle = document.getElementById("category");
const BackBtn = document.getElementById("close_contents_btn");
const TopBtn = document.getElementById("back_top_btn");
const SubNoContentsText = document.getElementById("sub_no_contents_text");
const slideText = document.getElementById("slide_text");//スライドできますのテキスト
let currentContainer = null;
let subCategories = document.getElementsByClassName("sub-category");
let subContents = document.getElementsByClassName("sub-content");

// 遷移アニメーション
const AnimationContainer = document.getElementById("animation_container");
const AnimationSlide = document.getElementById('slide');
const ImgElement = AnimationContainer.querySelector("img");
const TextElement = AnimationContainer.querySelector("p");

// 現在の親カテゴリーid
let currentParentId = null;
let subCategoryIdArray = [];

// 親カテゴリースライドのSwiper
const categorySwiper = new Swiper('.categorySwiper', {
    effect: 'coverflow', // スライダーに「カバーフロー」効果を適用します。中央のスライドが拡大され、3D的に表現されます。
    grabCursor: true,    // スライダー上でマウスカーソルが「掴む」形状になるように設定し、直感的なインターフェイスを提供します。
    centeredSlides: false, // スライダーを中央配置します。中央のスライドが常にビューポートの中央に表示されます。
    slidesPerView: 3,    // 画面上に同時に表示するスライドの数を指定します。この場合は「3枚」が表示されます。
    loop: true,          // スライドをループさせます。最後のスライドまで到達したら最初のスライドに戻ります。
    coverflowEffect: {   // カバーフロー効果の詳細設定を行うオプションです。
        rotate: 50,      // スライドの回転角度を設定します。値が大きいほどスライドが回転して立体感が増します。
        stretch: -30,      // スライド同士の間隔を制御します。正の値でスライド間が広がり、負の値で縮まります。
        depth: 100,      // 立体的な効果を強調するための奥行き（Z軸）を設定します。値が大きいほど深い効果が出ます。
        modifier: 1,     // 効果の強さを調整します。数値を大きくするほど効果が強調されます。
        slideShadows: true, // 各スライドに影を追加し、立体感を演出します。
    },
});


// サブカテゴリーとコンテンツSwiperの初期化を関数化
function initializeContentSwiper(className) {
    return new Swiper(className, {
        slidesPerView: 3, // 1行に表示するスライド数
        centeredSlides: false,
        grid: {
            rows: 2, // 縦に並べる数
        },
        spaceBetween: 30, // 各スライド間のスペース
        loop: false, // 順番が崩れないように
        // .swiperを横にスライドしたとき（slideChange イベント発火）
        on: {
            slideChange: function () {
                if (slideText && !slideText.classList.contains('opacity-0')) {
                    slideText.classList.add('opacity-0'); // フェードアウト
                }

            }
        },
    });
}

let contentSwiper = initializeContentSwiper(".swiper-1");//デフォルト

function MoveSlideToCenter(clickedIdx) {

    // 現在表示しているスライド3枚を取得
    const activeIndex = document.getElementsByClassName("swiper-slide-visible")

    let activeIndexArray = [];

    for (let i = 0; i < activeIndex.length; i++) {
        activeIndexArray.push(activeIndex[i].dataset.swiperSlideIndex);
    }

    // 3つのスライドindexからなる配列の真ん中である1番目がclickされたindexと異なる場合
    if(activeIndexArray[1]!==clickedIdx){
        let activeIndex = activeIndexArray.indexOf(clickedIdx);
        if(activeIndex===0){
            categorySwiper.slidePrev();
            return false;
        }else if(activeIndex===2){
            categorySwiper.slideNext();
            return false;
        }
    }else{
        return true;
    }

}

// メニューのカテゴリースライドをクリックしたときの処理
for (let i = 0; i < CategorySlide.length; i++) {
    CategorySlide[i].addEventListener("click", async function (e) {

        let slideIdx = e.currentTarget.dataset.swiperSlideIndex;

        // クリックされたスライドのidを取得
        currentParentId = e.currentTarget.id

        if(MoveSlideToCenter(slideIdx)){
            // クリックされたスライドのサイズと位置を取得
            const slideImage = e.currentTarget.querySelector("img");
            const slideRect = slideImage.getBoundingClientRect();

            const animImage = AnimationContainer.querySelector("img");
            const animText = AnimationContainer.querySelector("p");

            //カテゴリースライド非表示
            HideCategoryContainer();
            if (!contentSwiper.destroyed) {
                contentSwiper.destroy(true, true); // 破棄時にHTMLやCSSをリセット
            }
            if (contentSwiper.destroyed) {
                contentSwiper = initializeContentSwiper(`.swiper-${currentParentId}`); // Swiper再生成
            }

            currentContainer = document.getElementById(`container_${currentParentId}`);
            ShowContentVideos(currentContainer);

            const img = e.currentTarget.closest(".category-slide").querySelector("img");
            const text = e.currentTarget.closest(".category-slide").querySelector("p");

            //画像サイズ変更アニメーション
            ImgSizeChangeAnimation(slideRect,animImage,animText,img,text);

            await Sleep(1500); // 1.5秒待機

            subCategoryIdArray.push(currentParentId);//戻るボタン用に保存

            ShowContentContainer(animText); // コンテンツを表示

            HideSwiperSlide();

            ShowNextView(currentParentId); // 次のビューを表示

            // スライドの数が6以上の場合、スライドできますのテキストを表示
            let currentContents = document.getElementsByClassName("parent_id_" + currentParentId);
            let contentsLength = currentContents.length;

            if(contentsLength >6) {
                slideText.classList.remove("opacity-0");
            }

            // スライドできますの→をクリックしたとき、横にスライド
            slideText.addEventListener('click', function () {
                contentSwiper.slideNext();  // 次のスライドへ
            });

        }
    });
}

// TOPボタンをクリック時の処理
TopBtn.addEventListener("click", async function () {
    AnimationSlide.style.left = '0'; // 左端に移動
    AnimationSlide.style.opacity = '1'; // 表示

    await Sleep(1000); // 1秒待機

    HideContentContainer();
    ShowCategoryContainer();
    AnimationSlide.style.left = '100%'; // 右端に移動
    HideContentVideos(currentContainer);
    SubNoContentsText.classList.add("hidden");
    subCategoryIdArray = [];
    HideSwiperSlide();
    // 横にスライドできるのを明示する→を非表示
    if (!slideText.classList.contains('opacity-0')) {
        slideText.classList.add('opacity-0'); // フェードアウト
    }

    await Sleep(1000); // さらに1秒待機

    AnimationSlide.style.opacity = '0'; // 透明にする
    AnimationSlide.style.left = '-100%'; // 左端の外に移動
});

// 戻るボタンをクリック時の処理
BackBtn.addEventListener("click", async function () {

    // // ボタンやサブカテゴリーを無効化
    DisableInteractions();

    AnimationSlide.style.left = '0'; // 左端に移動
    AnimationSlide.style.opacity = '1'; // 表示
    await Sleep(1000);
    AnimationSlide.style.left = '100%'; // 右端の外に移動
    if (SubNoContentsText.classList.contains("hidden") === false) {
        SubNoContentsText.classList.add("hidden");
    }
    HideSwiperSlide();
    ShowNextView(subCategoryIdArray[subCategoryIdArray.length - 2]); // 配列の中から前のidを取得し、表示
    subCategoryIdArray.pop(); // 配列の一番最後を削除

    let element =null;
    let dataName = null;
    if (subCategoryIdArray.length === 1) {
        BackBtn.classList.add("hidden");//戻るボタン非表示
        // メニュースライドを取得し、そこからdata-nameを取得してページ上部タイトルに表示
        element = document.querySelector(`.category-slide[id="${currentParentId}"]`);
        dataName = element.dataset.name;
        CategoryTitle.innerText = dataName;
    }else{
        // サブカテゴリースライドを取得し、そこからdata-nameを取得してページ上部タイトルに表示
        element = document.querySelector(`.sub-category[data-id="${subCategoryIdArray[subCategoryIdArray.length - 1]}"]`);

        dataName = element.dataset.name;
        CategoryTitle.innerText = dataName;
    }

    await Sleep(1000); // さらに1秒待機

    // 透明にして右端に移動させる
    AnimationSlide.style.opacity = '0'; // 透明にする
    AnimationSlide.style.left = '-100%'; // 左端の外に移動

    // ボタンやサブカテゴリーを再度有効化
    EnableInteractions();
});

// 他のボタンやサブカテゴリーを無効化
function DisableInteractions() {
    // すべてのサブカテゴリーのクリックを無効にする
    if (subCategories.length > 0) {  // 配列が空でない場合
        for (let i = 0; i < subCategories.length; i++) {
            subCategories[i].style.pointerEvents = 'none'; // クリックを無効にする
        }
    }

    // 戻るボタンのクリックを無効にする
    BackBtn.style.pointerEvents = 'none';
}

// 他のボタンやサブカテゴリーを有効化
function EnableInteractions() {
    // すべてのサブカテゴリーのクリックを有効にする
    if (subCategories.length > 0) {  // 配列が空でない場合
        for (let i = 0; i < subCategories.length; i++) {
            subCategories[i].style.pointerEvents = 'auto'; // クリックを有効にする
        }
    }

    // 戻るボタンのクリックを有効にする
    BackBtn.style.pointerEvents = 'auto';
}

// カテゴリースライド表示
function ShowCategoryContainer(){
    CategoryContainer.style.display = "flex";
}

// カテゴリースライド非表示
function HideCategoryContainer(){
    CategoryContainer.style.display = "none";
}

// カテゴリー画像サイズ変更アニメーション
async function ImgSizeChangeAnimation(slideRect, animImage, animText, img, text) {
    // animation_container内の画像とテキストにスライドのサイズを適用
    animImage.style.width = `${slideRect.width}px`;
    animImage.style.height = `${slideRect.height}px`;

    AnimationContainer.classList.add("flex");
    AnimationContainer.classList.remove("hidden");

    //画像の読み込みが完了するまで待機
    await new Promise((resolve) => {
        ImgElement.src = img.src;
        TextElement.innerText = text.innerText; // テキストの設定
        ImgElement.onload = resolve; // 画像の読み込み完了後にresolveを呼び出す
    });

    //この後のコードは、上記のPromiseがresolveされるまで実行されません。

    //アニメーションを開始する
    animImage.classList.add("zoom-fade-out");
    animText.classList.add("move-up-fade-out");

    let sizeBigBtn = document.getElementById('btn1');

    if (sizeBigBtn.style.display !== 'none') {
        sizeBigBtn.classList.add('btn-fade-out');
    }

    // アニメーション完了後に非表示にする
    animImage.addEventListener("animationend", function () {
        AnimationContainer.classList.add("hidden");
        animImage.classList.remove("zoom-fade-out"); // クラスをリセット

        if (sizeBigBtn.style.display !== 'none') {
            sizeBigBtn.classList.remove('btn-fade-out');
        }
    });
}

// 一定時間待機する関数（ カテゴリー画像サイズ変更アニメーション用）setTimeoutで指定時間後にresolve()を呼び出す。
function Sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

// コンテンツ非表示
function HideContentContainer(){
    ContentsContainer.classList.add("hidden");
    BackBtn.classList.add("hidden");
    TopBtn.style.display = "none";
    CategoryTitle.style.display = "none";
}

// コンテンツ表示
function ShowContentContainer(text){
    ContentsContainer.classList.remove("hidden");
    ContentsContainer.classList.add("flex");
    TopBtn.style.display = "block";
    CategoryTitle.style.display = "block";
    CategoryTitle.innerText = text.innerText;
}

// 各学部動画表示
function ShowContentVideos(container){
    container.classList.remove("hideContainer");
    container.classList.add("flex");
    container.classList.add("contentSwiper");
}

// 各学部動画非表示
function HideContentVideos(container){
    container.classList.add("hideContainer");
    container.classList.remove("flex");
    container.classList.remove("contentSwiper");
}

// サブカテゴリーをクリックしたときの処理
for (let i = 0; i < subCategories.length; i++) {
    subCategories[i].addEventListener("click", async  function (e) {

        DisableInteractions();

        // ページ上部タイトル用（非同期処理 (Sleep(1000)) の後だと、e.currentTarget の参照が変わる、もしくは null になる可能性があるのでここで保存)
        const categoryName = e.currentTarget.getAttribute('data-name');

        AnimationSlide.style.left = '0'; // 左端に移動
        AnimationSlide.style.opacity = '1'; // 表示
        await Sleep(1000); // 1秒待機

        CategoryTitle.innerText = categoryName;//ページ上部タイトル変更

        AnimationSlide.style.left = '100%'; // 右端に移動

        HideSwiperSlide();// すべての `sub-contentとsub-category` を非表示

        let id = subCategories[i].getAttribute('data-id');

        subCategoryIdArray.push(id);//戻るボタン用に保存

        if(subCategoryIdArray.length > 1){
            BackBtn.classList.remove("hidden");
        }

        ShowNextView(id); // 次のビューを表示

        await Sleep(1000); // さらに1秒待機

        AnimationSlide.style.opacity = '0'; // 透明にする
        AnimationSlide.style.left = '-100%'; // 左端の外に移動

        EnableInteractions();
    });
}

// サブカテゴリーをクリックし、次のコンテンツとサブコンテンツを表示
function ShowNextView(id) {
    let categories_contents_data = document.getElementsByClassName("parent_id_" + id);

    // サブカテゴリーもコンテンツもない場合、no contentsを表示
    if (categories_contents_data.length === 0) {
        SubNoContentsText.classList.remove("hidden");//no contentsテキスト要素
        slideText.classList.add("opacity-0");
        return;
    }

    // データを表示
    for (let i = 0; i < categories_contents_data.length; i++) {
        categories_contents_data[i].classList.remove("hidden"); // `hidden` を削除
        categories_contents_data[i].classList.remove("!hidden"); // 念のため `!hidden` も削除
        categories_contents_data[i].classList.add("swiper-slide");
    }

    // swiperのリセット
    if (!contentSwiper.destroyed) {
        contentSwiper.destroy(true, true); // 破棄時にHTMLやCSSをリセット
    }

    let currentContents = document.getElementsByClassName("parent_id_" + id);
    let contentsLength = currentContents.length;

    if(contentsLength >6) {
        slideText.classList.remove("opacity-0");
    }else{
        slideText.classList.add("opacity-0");
    }

    contentSwiper = initializeContentSwiper(`.swiper-${currentParentId}`);
}

// swiper-slide classを持つサブカテゴリーとサブコンテンツを非表示
function HideSwiperSlide() {

    // すべての `sub-content` を非表示
    for (let j = 0; j < subContents.length; j++) {
        subContents[j].classList.add("!hidden"); // `hidden` を追加
        subContents[j].classList.remove("swiper-slide");
    }

    // すべての `sub-category` を非表示
    for (let j = 0; j < subCategories.length; j++) {
        subCategories[j].classList.add("!hidden");
        subCategories[j].classList.remove("swiper-slide"); // 念のため `!hidde
    }
}

