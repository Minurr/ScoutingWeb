document.getElementById('analyzeButton').addEventListener('click', function () {
    const output = document.getElementById('output');
    output.textContent = "IronMaple-AI分析数据中，请稍后... （预计40s）";

    fetch('', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'action=analyze'
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // 处理HTML代码，去除 ```html 和 ``` 标识
                let analysisContent = data.analysis.replace(/```html|```/g, "");
                output.innerHTML = analysisContent;
            } else {
                output.innerHTML = `<span class="error">Error: ${data.message}</span>`;
            }
        })
        .catch(error => {
            output.innerHTML = `<span class="error">An unexpected error occurred: ${error}</span>`;
        });
});
