document.addEventListener('DOMContentLoaded', function() {
    const loadingScreen = document.getElementById('loadingScreen');
    const images = document.querySelectorAll('img');
    const loadingText = document.getElementById('loading_text');
    let loadedCount = 0;

    updateLoadingText();

    images.forEach((img) => {
        if (img.complete) {
            // すでにロード済みの画像
            loadedCount++;
            updateLoadingText();
        } else {
            img.addEventListener('load', handleImageLoad);
            img.addEventListener('error', handleImageLoad);
        }
    });

    // すべてロード済みか一度チェック
    if (loadedCount === images.length) {
        hideLoadingScreen();
    }

    function handleImageLoad() {
        loadedCount++;
        updateLoadingText();
        if (loadedCount === images.length) {
            hideLoadingScreen();
        }
    }

    function updateLoadingText() {
        loadingText.textContent = 'Loading... (' + loadedCount + '/' + images.length + ')';
    }

    function hideLoadingScreen() {
        loadingScreen.style.opacity = '0';
        setTimeout(() => {
            loadingScreen.style.display = 'none';
        }, 500);
    }
});
