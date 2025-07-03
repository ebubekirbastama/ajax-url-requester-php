<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>EBS AJAX URL Requester - PHP + cURL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f0f2f5; }
        .container { max-width: 720px; margin-top: 40px; }
        textarea { resize: vertical; min-height: 100px; }
        #logArea { 
            background: #fff; 
            padding: 10px; 
            border: 1px solid #ddd; 
            border-radius: 5px; 
            max-height: 300px; 
            overflow-y: auto; 
            white-space: pre-wrap;
        }
    </style>
</head>
<body>
<div class="container">
    <h3 class="mb-4">🌐 AJAX URL Requester - PHP + cURL</h3>

    <form id="requestForm" class="card p-3 mb-4 shadow-sm">
        <div class="mb-3">
            <label class="form-label">URL'leri alt alta yazınız:</label>
            <textarea name="urls" class="form-control" placeholder="https://site1.com/api?key=xxx&#10;https://site2.com/api?key=yyy"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Bekleme süresi (dakika):</label>
            <input type="number" step="0.1" name="wait" class="form-control" value="2" style="max-width:120px;">
        </div>
        <div class="mb-3">
            <div class="progress" style="height: 25px;">
                <div id="progressBar" class="progress-bar" role="progressbar" style="width: 0%">0%</div>
            </div>
        </div>
        <button type="submit" class="btn btn-success" id="startBtn">Başlat</button>
    </form>

    <h5>📝 Log Kayıtları:</h5>
    <div id="logArea">Hazır bekliyor...</div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script>
let isRunning = false;
let total = 0;
let completed = 0;

$('#requestForm').on('submit', function(e) {
    e.preventDefault();
    if (isRunning) return;

    $('#logArea').html('<span>İşlem başlatılıyor...</span>\n');
    $('#progressBar').css('width', '0%').text('0%');
    isRunning = true;
    completed = 0;
    $('#startBtn').prop('disabled', true).text('Çalışıyor...');

    $.post('process.php', $(this).serialize(), function(res) {
        if (res.success) {
            total = res.total;
            processNext();
        } else {
            appendLog(res.message, 'red');
            stopProcess();
        }
    }, 'json');
});

function processNext() {
    $.get('process.php', { next: 1 }, function(res) {
        if (res.done) {
            appendLog("🎉 Tüm istekler tamamlandı.");
            stopProcess();
        } else if (res.log) {
            showLogWithStatus(res.log, res.status);
            completed++;
            updateProgress();
            setTimeout(processNext, 1000);
        }
    }, 'json');
}

function showLogWithStatus(message, status) {
    let color = 'black';
    let icon = '';

    if (status >= 200 && status < 300) {
        color = 'green';
        icon = '🟢';
    } else if (status >= 300 && status < 400) {
        color = 'orange';
        icon = '🟡';
    } else if (status >= 400) {
        color = 'red';
        icon = '🔴';
    }

    $('#logArea').append(`<div style="color:${color}">${icon} ${message}</div>`);
    $('#logArea').scrollTop($('#logArea')[0].scrollHeight);
}

function appendLog(message, color = 'black') {
    $('#logArea').append(`<div style="color:${color}">${message}</div>`);
    $('#logArea').scrollTop($('#logArea')[0].scrollHeight);
}

function updateProgress() {
    if (total === 0) return;
    const percent = Math.round((completed / total) * 100);
    $('#progressBar').css('width', percent + '%').text(percent + '%');
}

function stopProcess() {
    isRunning = false;
    $('#startBtn').prop('disabled', false).text('Başlat');
}
</script>
</body>
</html>
