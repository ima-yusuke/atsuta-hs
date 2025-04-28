document.addEventListener('DOMContentLoaded', function() {
    const loadingScreen = document.getElementById('loadingScreen');
    const images = document.querySelectorAll('img');
    const loadingText = document.getElementById('loading_text');
    let loadedCount = 0;

    updateLoadingText();

    images.forEach((img) => {
        if (img.complete) {
            loadedCount++;
            updateLoadingText();
        } else {
            img.addEventListener('load', () => {
                loadedCount++;
                updateLoadingText();
                checkAllLoaded();
            });
            img.addEventListener('error', () => {
                loadedCount++;
                updateLoadingText();
                checkAllLoaded();
            });
        }
    });

    function updateLoadingText() {
        loadingText.textContent = 'Loading... (' + loadedCount + '/' + images.length + ')';
    }

    function checkAllLoaded() {
        if (loadedCount === images.length) {
            hideLoadingScreen();
        }
    }

    function hideLoadingScreen() {
        loadingScreen.style.opacity = '0';
        setTimeout(() => {
            loadingScreen.style.display = 'none';
        }, 500);
    }
});
