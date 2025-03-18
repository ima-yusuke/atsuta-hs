// フルスクリーン表示
document.getElementById('btn1').addEventListener('click', function(){

    document.body.requestFullscreen().then(() => {
        document.getElementById('btn1').style.display = 'none';
    });
});

// フルスクリーンが終了したときの処理
document.addEventListener('fullscreenchange', () => {
    if (!document.fullscreenElement) { // フルスクリーンが解除されたとき
        document.getElementById('btn1').style.display = 'block';
    }
});

// 'Escape'キーが押されたときにボタンを再表示
document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
        if (!document.fullscreenElement) {
            document.getElementById('btn1').style.display = 'block';
        }
    }
});
