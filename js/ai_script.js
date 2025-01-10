document.getElementById('analyzeButton').addEventListener('click', function () {
    const output = document.getElementById('output');
    output.textContent = "IronMaple-AI分析数据中，请稍后...";

    fetch('', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'action=analyze'
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                output.innerHTML = data.analysis;
            } else {
                output.innerHTML = `<span class="error">Error: ${data.message}</span>`;
            }
        })
        .catch(error => {
            output.innerHTML = `<span class="error">An unexpected error occurred: ${error}</span>`;
        });
});