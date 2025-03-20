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

    categoryItems.forEach((item) => {
        item.addEventListener("click", () => {
            // data-category-id属性からカテゴリーIDを取得
            const categoryId = item.getAttribute("data-category-id");
            document.querySelectorAll('.video-contents').forEach(button => {
                const contentCategoryId = button.getAttribute('data-content-category-id');
                const contentDetails = button.nextElementSibling;
                const show = document.querySelectorAll('.bi-chevron-down');
                const none = document.querySelectorAll('.bi-chevron-up');
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
                    button.classList.remove('hidden');
                    button.classList.add('flex');
                }
            });
            document.querySelectorAll('.nested-category').forEach(button => {
                const parentCategoryId = button.getAttribute('data-parent-category-id');
                button.classList.remove('flex');
                button.classList.add('hidden');
                button.classList.add('mb-2');
                if (categoryId === parentCategoryId) {
                    button.classList.remove('hidden');
                    button.classList.add('flex');
                }
            });
            // 新規コンテンツの表示
            newContent.classList.add('hidden');
            if (categoryId === 'new') {
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

    // 並び替え処理
    const sortable = document.getElementById('sortable-content-list');
    Sortable.create(sortable, {
        animation: 150,
        filter: 'input, select, textarea, .update-btn, .delete-btn',
        preventOnFilter: false,
        onSort: onSortEvent
    });

    // カテゴリーのアコーディオン
    document.querySelectorAll(".category-item").forEach((item) => {
        item.addEventListener("click", function (event) {
            event.stopPropagation(); // クリックイベントのバブリングを防ぐ

            let childrenContainer = this.querySelector(":scope > .child-categories"); // 直下の子要素
            if (childrenContainer) {
                childrenContainer.classList.toggle("hidden");
            }
        });
    });
});

// 以下並び替え処理
function onSortEvent(e) {
    const draggedCategoryId = e.item.getAttribute('data-sort-category-id');
    UpdateOrder(e.target, "sortable-item", '/dashboard/update-content-order', draggedCategoryId);
}

function UpdateOrder(target, selector, url, draggedCategoryId) {
    const items = target.querySelectorAll('.' + selector);
    let orderData = [];

    for (let i = 0; i < items.length; i++) {
        let id = items[i].id;
        orderData.push({ id: id, order: i + 1 });
    }
    UpdateContentOrderRequest(url, orderData, draggedCategoryId);
}

async function UpdateContentOrderRequest(url, orderData, draggedCategoryId) {
    try {
        const response = await FetchData(url, 'POST', true, JSON.stringify({
            orderData: orderData,
            draggedCategoryId: draggedCategoryId
        }));

        if (response.status === "success") {
            // サーバーからのレスポンスを元に並び順を更新
            orderData.forEach(data => {
                const item = document.getElementById(data.id);
                if (item) {
                    item.setAttribute("data-order", data.order);
                }
            });
            console.log("並び替えが完了しました！");
        } else {
            console.error("並び替えの更新に失敗しました");
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

function FetchData(url, method, headerData, bodyData) {
    const headers = {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    };
    if (headerData) {
        Object.assign(headers, {
            'Content-Type': 'application/json'
        });
    }

    return fetch(url, {
        method: method,
        headers: headers,
        body: bodyData,
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .catch(error => {
            console.error('Error:', error);
            throw new Error(error.message);
        });
}
