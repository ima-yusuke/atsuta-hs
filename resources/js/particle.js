(async () => {
    // Snowプリセットをロード
    await loadLinksPreset(tsParticles);

    // tsParticlesを初期化
    await tsParticles.load({
        id: "tsparticles",
        options: {
            preset: "links", // "snow"プリセットを指定
            background: {
                color: {
                    value: "#001f3f", // 背景色をダークブルーに設定
                },
            },
        },
    });
})();
