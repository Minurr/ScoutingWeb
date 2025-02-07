document.getElementById('analyzeButton').addEventListener('click', function () {
    const output = document.getElementById('output');
    output.textContent = "IronMaple-AI分析数据中，请稍后... （预计1~2min）";

    fetch('', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'action=analyze'
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                let analysisContent = data.analysis.replace(/```html|```/g, "");
                output.innerHTML = analysisContent;

                const timestamp = new Date().toLocaleString();
                const analysisWithTimestamp = `分析时间: ${timestamp}\n\n${analysisContent}`;

                fetch('./save_analysis.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ analysis: analysisWithTimestamp })
                }).then(saveResponse => {
                    if (!saveResponse.ok) {
                        console.error('Failed to save analysis data.');
                    }
                }).catch(saveError => {
                    console.error('Error saving analysis data:', saveError);
                });
            } else {
                output.innerHTML = `<span class="error">Error: ${data.message}</span>`;
            }
        })
        .catch(error => {
            output.innerHTML = `<span class="error">An unexpected error occurred: ${error}</span>`;
        });
});
