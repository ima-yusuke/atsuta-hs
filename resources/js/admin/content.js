import '/resources/js/app.js';

// categoryアコーディオンの切り替え
document.querySelectorAll('.nested-category').forEach(button => {
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

// contentアコーディオンの切り替え
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
    const categoryItems = document.querySelectorAll(".category-item");
    const newContent = document.getElementById('content-new');
    const newCategory = document.getElementById('category-new');
    const newContentTitle = document.getElementById('content-title-new');
    const newCategoryTitle = document.getElementById('category-title-new');

    // カテゴリーがクリックされたときの処理
    function handleCategorySelection(item) {
        // data-category-id属性からカテゴリーIDを取得
        const categoryId = item.getAttribute("data-category-id");

        // コンテンツのアコーディオン処理
        toggleAccordion('.video-contents', 'data-content-category-id', categoryId);

        // カテゴリーのアコーディオン処理
        toggleAccordion('.nested-category', 'data-parent-category-id', categoryId);

        // 新規コンテンツの表示処理
        toggleNewContentDisplay(categoryId);
    }

    // 汎用的なアコーディオンの切り替え関数
    function toggleAccordion(selector, dataAttr, categoryId) {
        document.querySelectorAll(selector).forEach(button => {
            const contentCategoryId = button.getAttribute(dataAttr);
            const contentDetails = button.nextElementSibling;
            const showIcons = document.querySelectorAll('.bi-chevron-down');
            const hideIcons = document.querySelectorAll('.bi-chevron-up');

            button.classList.remove('flex');
            button.classList.add('hidden', 'mb-2');
            contentDetails.classList.add('hidden');
            contentDetails.classList.remove('mb-2');

            showIcons.forEach(icon => icon.classList.remove('hidden'));
            hideIcons.forEach(icon => icon.classList.add('hidden'));

            if (categoryId === contentCategoryId) {
                button.classList.remove('hidden');
                button.classList.add('flex');
            }
        });
    }

    // 新規コンテンツ・カテゴリーの表示切り替え関数
    function toggleNewContentDisplay(categoryId) {
        // 新規コンテンツ
        newContent.classList.add('hidden');
        newContentTitle.classList.add('hidden');
        if (categoryId === 'content-new') {
            newContent.classList.remove('hidden');
            newContentTitle.classList.remove('hidden');
        }

        // 新規カテゴリー
        newCategory.classList.add('hidden');
        newCategoryTitle.classList.add('hidden');
        if (categoryId === 'category-new') {
            newCategory.classList.remove('hidden');
            newCategoryTitle.classList.remove('hidden');
        }
    }

    // カテゴリーの切り替え
    document.querySelectorAll(".category-item").forEach(item => {
        item.addEventListener("click", () => handleCategorySelection(item));
    });

    // 閉じるボタンのクリックイベント
    document.querySelectorAll('.close-button').forEach(button => {
        button.addEventListener('click', () => {
            const alertArea = button.closest('.alert-area');
            alertArea.remove();
        });
    });

    // カテゴリー選択時の初期表示
    const selectedCategoryId = document.getElementById('clicked-category').getAttribute('data-clicked-category');
    let targetElement;
    if (selectedCategoryId === '0') {
        targetElement = document.getElementById('category-list-0');
    } else if (selectedCategoryId === 'category_new') {
        targetElement = document.getElementById('category-list-new');
    } else if (selectedCategoryId === 'content_new') {
        targetElement = document.getElementById('content-list-new');
    } else {
        targetElement = document.getElementById('category-list-' + selectedCategoryId);
    }

    if (targetElement) {
        handleCategoryClick(new Event('click'), targetElement); // クリック処理の関数
        handleCategorySelection(targetElement); // カテゴリー選択処理の関数
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
        const previewContainer = document.getElementById(`preview-container_${id}`);
        const preview = document.getElementById(`preview_${id}`);

        if (!previewContainer || !preview) {
            // console.error(`プレビュー要素が見つかりません: preview-container_${id}, preview_${id}`);
            return;
        }

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                previewContainer.classList.remove('hidden');
                previewContainer.classList.add('flex');
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = "";
            previewContainer.classList.remove('flex');
            previewContainer.classList.add('hidden');
        }
    }

    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', function (event) {
            let id = input.getAttribute("id");

            if (input.name === "category_img_new") {
                id = "category_new";  // category用の新規ID
            } else if (input.name === "content_img_new") {
                id = "content_new";  // content用の新規ID
            } else if (input.name.startsWith("category_img_")) {
                id = "category_" + id.replace("category_img_", ""); // 既存カテゴリー
            } else if (input.name.startsWith("content_img_")) {
                id = "content_" + id.replace("content_img_", ""); // 既存コンテンツ
            }
            // console.log("プレビュー対象ID:", id);
            previewImage(event, id);
        });
    });

    // コンテンツ並び替え処理
    const contentSortable = document.getElementById('sortable-content-list');
    Sortable.create(contentSortable, {
        animation: 150,
        filter: 'input, select, textarea, .update-btn, .delete-btn',
        preventOnFilter: false,
        onSort: onContentSortEvent
    });

    // カテゴリー並び替え処理
    const categorySortable = document.getElementById('sortable-category-list');
    Sortable.create(categorySortable, {
        animation: 150,
        filter: 'input, select, textarea, .update-btn, .delete-btn',
        preventOnFilter: false,
        onSort: onCategorySortEvent
    });

    // カテゴリーnavのアコーディオン
    document.querySelectorAll(".category-item").forEach((item) => {
        item.addEventListener("click", function (event) {
            handleCategoryClick(event, item);
        });
    });

    function handleCategoryClick(event, item) {
        event.stopPropagation(); // クリックイベントのバブリングを防ぐ

        // 直下の子要素を取得して表示・非表示を切り替え
        let childrenContainer = item.querySelector(":scope > .child-categories");
        if (childrenContainer) {
            childrenContainer.classList.toggle("hidden");
        }

        // カテゴリーのハイライト表示
        highlightCategory(item.getAttribute("data-category-id"));
    }

    function highlightCategory(categoryId) {
        // すべてのカテゴリースタイルをリセット
        document.querySelectorAll(".category-item").forEach((item) => {
            item.style.backgroundColor = "";
        });
        document.querySelectorAll(".category-item-title").forEach((item) => {
            item.style.backgroundColor = "";
        });

        let clickedCategory;
        if (categoryId === "0") {
            clickedCategory = document.getElementById("category-list-0");
        } else if (categoryId === "category-new") {
            clickedCategory = document.getElementById("category-list-new");
        } else if (categoryId === "content-new") {
            clickedCategory = document.getElementById("content-list-new");
        } else {
            clickedCategory = document.getElementById("category-list-" + categoryId)?.firstElementChild;
        }

        if (clickedCategory) {
            clickedCategory.style.backgroundColor = "#d1e5ff";
        }
    }

});

// コンテンツ並び替え処理
function onContentSortEvent(e) {
    const draggedCategoryId = e.item.getAttribute('data-sort-category-id');
    UpdateContentOrder(e.target, "sortable-item", '/dashboard/update-content-order', draggedCategoryId);
}

// カテゴリー並び替え処理
function onCategorySortEvent(e) {
    UpdateCategoryOrder(e.target, "sortable-item", '/dashboard/update-category-order');
}

function UpdateContentOrder(target, selector, url, draggedCategoryId) {
    const items = target.querySelectorAll('.' + selector);
    let orderData = [];

    for (let i = 0; i < items.length; i++) {
        let id = items[i].id;
        orderData.push({ id: id, order: i + 1 });
    }
    UpdateContentOrderRequest(url, orderData, draggedCategoryId);
}
function UpdateCategoryOrder(target, selector, url) {
    const items = target.querySelectorAll('.' + selector);
    let orderData = [];

    for (let i = 0; i < items.length; i++) {
        let id = items[i].id;
        orderData.push({ id: id, order: i + 1 });
    }
    UpdateCategoryOrderRequest(url, orderData);
}

async function UpdateContentOrderRequest(url, orderData, draggedCategoryId) {
    try {
        const response = await FetchContentData(url, 'POST', true, JSON.stringify({
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
            // console.log("並び替えが完了しました！");
        } else {
            console.error("並び替えの更新に失敗しました");
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

async function UpdateCategoryOrderRequest(url, orderData) {
    try {
        const response = await FetchCategoryData(url, 'POST', true, JSON.stringify({
            orderData: orderData,
        }));

        if (response.status === "success") {
            // サーバーからのレスポンスを元に並び順を更新
            orderData.forEach(data => {
                const item = document.getElementById(data.id);
                if (item) {
                    item.setAttribute("data-order", data.order);
                }
            });
            // console.log("並び替えが完了しました！");
        } else {
            console.error("並び替えの更新に失敗しました");
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

function FetchContentData(url, method, headerData, bodyData) {
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

function FetchCategoryData(url, method, headerData, bodyData) {
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
