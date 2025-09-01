// document.addEventListener('DOMContentLoaded', function() {
//     const loadingScreen = document.getElementById('loadingScreen');
//     const loadingText = document.getElementById('loading_text');
//     const images = document.querySelectorAll('img');
//     let loadedCount = 0;
//     const totalCount = images.length;
//     let windowLoaded = false;
//     let fakeProgress = 0;
//
//     // 最初に表示
//     updateLoadingText();
//
//     images.forEach((img) => {
//         if (img.complete) {
//             loadedCount++;
//             updateLoadingText();
//         } else {
//             img.addEventListener('load', handleImageLoad);
//             img.addEventListener('error', handleImageLoad);
//         }
//     });
//
//     function handleImageLoad() {
//         loadedCount++;
//         updateLoadingText();
//     }
//
//     window.addEventListener('load', function() {
//         windowLoaded = true;
//         fakeProgress = 100;
//         updateLoadingText();
//         hideLoadingScreen();
//     });
//
//     function updateLoadingText() {
//         let percent = Math.round((loadedCount / totalCount) * 90); // 90%までimgで進める
//         if (windowLoaded) {
//             percent = 100; // windowがload完了したら100%
//         }
//         loadingText.textContent = `Loading... ${percent}%`;
//     }
//
//     function hideLoadingScreen() {
//         loadingScreen.style.opacity = '0';
//         setTimeout(() => {
//             loadingScreen.style.display = 'none';
//         }, 500);
//     }
// });
