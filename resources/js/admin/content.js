import '/resources/js/app.js';

// アコーディオンの切り替え
document.querySelectorAll('.video-contents').forEach(button => {
    button.addEventListener('click', () => {
        const opened = button.querySelector('.opened');
        const closed = button.querySelector('.closed');
        const details = button.nextElementSibling;
        const isClose = details.classList.contains('hidden');
        opened.classList.toggle('hidden', !isClose);
        closed.classList.toggle('hidden', isClose);
        button.classList.toggle('mb-2', !isClose);
        details.classList.toggle('mb-2', isClose);
        details.classList.toggle('hidden', !isClose);
        details.classList.toggle('flex', isClose);
    });
});

document.addEventListener("DOMContentLoaded", () => {
    // カテゴリー切り替え
    const categoryItems = document.querySelectorAll(".category-item");
    const newContent = document.getElementById('new-content');
    const allCategoryTitles = document.querySelectorAll('.category-title');  // 全てのカテゴリタイトルを取得

    categoryItems.forEach((item) => {
        item.addEventListener("click", () => {
            // data-category-id属性からカテゴリーIDを取得
            const categoryId = item.getAttribute("data-category-id");
            const categoryTitleNew = document.getElementById('category-title-new');
            document.querySelectorAll('.video-contents').forEach(button => {
                const categoryTitle = document.getElementById('category-title-' + categoryId);
                const contentCategoryId = button.getAttribute('data-content-category-id');
                const contentDetails = button.nextElementSibling;
                const show = document.querySelectorAll('.bi-chevron-down');
                const none = document.querySelectorAll('.bi-chevron-up');
                categoryTitleNew.classList.add('hidden');
                if (categoryTitle) {
                    categoryTitle.classList.add('hidden');
                }
                button.classList.remove('flex');
                button.classList.add('hidden');
                button.classList.add('mb-2');
                contentDetails.classList.add('hidden');
                contentDetails.classList.remove('mb-2');
                show.forEach(icon => {
                    icon.classList.remove('hidden');
                });
                none.forEach(icon => {
                    icon.classList.add('hidden');
                });
                if (categoryId === contentCategoryId) {
                    if (categoryTitle) {  // categoryTitleが存在する場合のみ表示
                        categoryTitle.classList.remove('hidden');
                    }
                    button.classList.remove('hidden');
                    button.classList.add('flex');
                }
            });

            // 他のカテゴリータイトルを非表示に
            allCategoryTitles.forEach(title => {
                if (title.id !== 'category-title-' + categoryId) {
                    title.classList.add('hidden');
                } else {
                    title.classList.remove('hidden');
                }
            });

            // 新規コンテンツの表示
            newContent.classList.add('hidden');
            if (categoryId === '0') {
                categoryTitleNew.classList.remove('hidden');
                newContent.classList.remove('hidden');
            }
        });
    });

    // 閉じるボタンのクリックイベント
    document.querySelectorAll('.close-button').forEach(button => {
        button.addEventListener('click', () => {
            const alertArea = button.closest('.alert-area');
            alertArea.remove();
        });
    });

    // カテゴリー選択時の初期表示
    const selectedCategoryId = document.getElementById('selected-category').getAttribute('data-selected-category');
    if (selectedCategoryId) {
        const button = document.getElementById('category-list-' + selectedCategoryId);
        button.click();
    } else {
        const button = document.getElementById('category-list-0');
        button.click();
    }

    // エラー時に該当アコーディオンを開く処理
    const errorAccordions = document.querySelectorAll('.has-error');
    if (errorAccordions.length > 0) {
        errorAccordions.forEach(accordion => {
            const button = accordion.previousElementSibling;
            if (button) {
                const icons = button.querySelectorAll('i');
                icons.forEach(icon => icon.classList.toggle('hidden'));
                button.classList.toggle('mb-2');
            }
            accordion.classList.toggle('hidden');
            accordion.classList.toggle('flex');

            // 最初のエラー箇所にスクロール移動
            accordion.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    }

    // 画像のプレビュー
    function previewImage(event, id) {
        const input = event.target;
        const previewContainer = document.getElementById('preview-container_' + id);
        const preview = document.getElementById('preview_' + id);

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                previewContainer.classList.remove('hidden'); // プレビューを表示
                previewContainer.classList.add('flex');
            };
            reader.readAsDataURL(input.files[0]); // ファイルを読み込んでURLに変換
        } else {
            preview.src = "";
            previewContainer.classList.remove('flex');
            previewContainer.classList.add('hidden'); // 画像が選択されていない場合は非表示
        }
    }

    // すべての input[type="file"] にイベントリスナーを設定
    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', function (event) {
            let id = input.getAttribute("id").replace("img_", ""); // idからcontentのIDを取得
            if (input.id === "img_new") {
                id = "new"; // 新規コンテンツの場合
            }
            previewImage(event, id);
        });
    });
});
