document.getElementById('uploadForm').addEventListener('submit', async function(event) {
    event.preventDefault();

    const teamCode = document.getElementById('team_code').value;
    const matchCode = document.getElementById('match_code').value;
    const videoFile = document.getElementById('video_file').files[0];

    if (!teamCode || !matchCode || !videoFile) {
        document.getElementById('responseMessage').innerHTML = '<p class="error">Please fill in all fields</p>';
        return;
    }

    // Compress video
    const compressedVideoFile = await compressVideo(videoFile);

    const formData = new FormData();
    formData.append('team_code', teamCode);
    formData.append('match_code', matchCode);
    formData.append('video', compressedVideoFile);
    const progressContainer = document.querySelector('.progress-container');
    const progressBar = document.querySelector('.progress-bar');
    const progressText = document.querySelector('.progress-text');

    progressContainer.style.display = 'block';
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'https://api4.lfcup.cn/upload.php', true);

    xhr.upload.addEventListener('progress', function(event) {
        if (event.lengthComputable) {
            const percent = Math.round((event.loaded / event.total) * 100);
            progressBar.style.width = percent + '%';
            progressText.textContent = percent + '%';
        }
    });

    xhr.onload = function() {
        const response = JSON.parse(xhr.responseText);
        if (response.success) {
            document.getElementById('responseMessage').innerHTML = `<p class="success">${response.message}</p><p>Video Link: <a href="${response.file_link}" target="_blank">${response.file_link}</a></p>`;

            const saveData = new FormData();
            saveData.append('team_code', teamCode);
            saveData.append('match_code', matchCode);
            saveData.append('video_path', response.file_link);

            const saveXhr = new XMLHttpRequest();
            saveXhr.open('POST', 'video.php', true);
            saveXhr.onload = function() {
                const saveResponse = JSON.parse(saveXhr.responseText);
                if (saveResponse.success) {
                    document.getElementById('responseMessage').innerHTML += `<p class="success">${saveResponse.message}</p>`;
                } else {
                    document.getElementById('responseMessage').innerHTML += `<p class="error">${saveResponse.message}</p>`;
                }
            };
            saveXhr.send(saveData);
        } else {
            document.getElementById('responseMessage').innerHTML = `<p class="error">${response.message}</p>`;
        }
        progressContainer.style.display = 'none';
    };

    xhr.onerror = function() {
        document.getElementById('responseMessage').innerHTML = '<p class="error">Upload failed. Please try again or contact admin.</p>';
        progressContainer.style.display = 'none';
    };

    xhr.send(formData);
});

async function compressVideo(file) {
    const { createFFmpeg, fetchFile } = FFmpeg;
    const ffmpeg = createFFmpeg({ log: true });
    await ffmpeg.load();
    ffmpeg.FS('writeFile', 'input.mp4', await fetchFile(file));
    // Higher compression ratio
    await ffmpeg.run('-i', 'input.mp4', '-vcodec', 'libx264', '-preset', 'slow', '-crf', '51', 'output.mp4');
    const data = ffmpeg.FS('readFile', 'output.mp4');
    return new Blob([data.buffer], { type: 'video/mp4' });
}
