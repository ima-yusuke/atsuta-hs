// フルスクリーン表示
document.getElementById('btn1').addEventListener('click', function(){
    document.body.requestFullscreen().then(() => {
        document.body.style.backgroundColor = '#E9E9E9';
        document.body.style.backgroundImage = `linear-gradient(0deg, transparent calc(100% - 1px), #f0f0f0 calc(100% - 1px)),
            linear-gradient(90deg, transparent calc(100% - 1px), #f0f0f0 calc(100% - 1px))`;
        document.body.style.backgroundSize = "16px 16px";
    });
    document.getElementById('btn1').style.display = 'none';
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
