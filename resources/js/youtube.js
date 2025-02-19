// const tag = document.createElement('script');
// tag.src = "https://www.youtube.com/iframe_api";
// const firstScriptTag = document.getElementsByTagName('script')[2];
// console.log(firstScriptTag);
// firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
//
// // YouTube IFrame Player API のスクリプトが完全にロードされ、API が準備完了したタイミングで 自動的に呼び出されます。
// function onYouTubeIframeAPIReady() {
//     // すべての iframe を取得
//     const iframes = document.querySelectorAll('.youtubePlayer');
//     // 各 iframe に対して YT.Player を作成
//     iframes.forEach((iframe) => {
//         new YT.Player(iframe, {
//             events: {
//                 'onStateChange': (event) => onPlayerStateChange(event, iframe)
//             }
//         });
//     });
// }
//
// // プレイヤー状態の変更時に呼び出される
// function onPlayerStateChange(event, iframe) {
//     if (event.data === YT.PlayerState.PLAYING) {
//         // フルスクリーンに切り替える
//         if (iframe.requestFullscreen) {
//             iframe.requestFullscreen();
//         }
//     }
// }

// function onYouTubeIframeAPIReady() {
//     // API が準備完了した際に実行される処理
//     console.log('YouTube IFrame Player API is ready!');
// }
//
// // 2. スクリプトを動的に読み込む
// const tag = document.createElement('script');
// tag.src = "https://www.youtube.com/iframe_api";
// document.head.appendChild(tag);
//
