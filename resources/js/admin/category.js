import '/resources/js/app.js';
document.addEventListener('DOMContentLoaded', () => {
    // アコーディオンの切り替え
    document.querySelectorAll('#sortable-category-list > .sortable-item > .categories').forEach(button => {
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

    // 閉じるボタンのクリックイベント
    document.querySelectorAll('.close-button').forEach(button => {
        button.addEventListener('click', () => {
            const alertArea = button.closest('.alert-area');
            alertArea.remove();
        });
    });

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

    const errorNewContent = document.getElementById('error-new-category');
    if (errorNewContent) {
        errorNewContent.scrollIntoView({ behavior: 'smooth', block: 'start' });
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
            let id = input.getAttribute("id").replace("img_", ""); // idからcategoryのIDを取得
            if (input.id === "img_new") {
                id = "new"; // 新規カテゴリーの場合
            }
            previewImage(event, id);
        });
    });
});
