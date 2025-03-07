import '/resources/js/app.js';
import Sortable from 'sortablejs';

document.addEventListener('DOMContentLoaded', () => {
    const categoryList = document.getElementById('categories');
    let contents = []; // ここでcontentsを定義

    const updateOrder = () => {
        const categories = [];

        // カテゴリの並べ替え
        categoryList.querySelectorAll('.category-item').forEach((item, index) => {
            const id = item.getAttribute('data-id');
            const parentId = item.getAttribute('data-parent-id');
            categories.push({
                id: id,
                order: index,
                parent_id: parentId === 'null' ? null : parentId,
                children: [] // 子カテゴリーの並び順も送信
            });

            // 子カテゴリーの並べ替え (再帰的に処理)
            item.querySelectorAll('.nested-category > .category-item').forEach((subItem, subIndex) => {
                const subId = subItem.getAttribute('data-id');
                categories[categories.length - 1].children.push({
                    id: subId,
                    order: subIndex,
                    parent_id: id
                });

                // 孫カテゴリー以下の処理 (さらに再帰的に)
                subItem.querySelectorAll('.nested-category > .category-item').forEach((subSubItem, subSubIndex) => {
                    const subSubId = subSubItem.getAttribute('data-id');
                    categories[categories.length - 1].children[categories[categories.length - 1].children.length - 1].children.push({
                        id: subSubId,
                        order: subSubIndex,
                        parent_id: subId
                    });
                });
            });

            // コンテンツの並べ替え
            const contentList = item.querySelector('.content-list');
            contentList.querySelectorAll('.content-item').forEach((contentItem, contentIndex) => {
                const contentId = contentItem.getAttribute('data-id');
                const categoryId = item.getAttribute('data-id');
                contents.push({
                    id: contentId,
                    order: contentIndex,
                    category_id: categoryId
                });
            });
        });

        // APIにデータを送信
        fetch('/dashboard/update-order', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ categories, contents })
        }).then(response => response.json())
            .then(data => console.log('Order updated:', data))
            .catch(error => console.error('Error:', error));
    };

    new Sortable(categoryList, {
        animation: 150,
        group: 'categories',
        onEnd: updateOrder,
        handle: '.category-item',
    });

    // コンテンツの並べ替え
    const contentLists = document.querySelectorAll('.content-list');
    contentLists.forEach(contentList => {
        new Sortable(contentList, {
            animation: 150,
            group: 'contents',
            onEnd: updateOrder,
            handle: '.content-item',
        });
    });
});
