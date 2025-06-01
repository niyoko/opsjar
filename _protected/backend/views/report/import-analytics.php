    <?php
    use yii\helpers\Html;
    use yii\helpers\Url;
    ?>

    <style>
        .card-custom {
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            padding: 20px;
            background-color: #fff;
            min-height: 300px; /* Minimum height for the card */
        }

        .upload-box {
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s;
            background-color: #f8f8ff;
            border: 2px #e7e9f5;
            border-style: dashed;
            margin-bottom: 15px;
        }

        .upload-box.dragover {
            background-color: #f9f9f9;
        }

        .upload-icon {
            color: #f39c12;
            font-size: 40px;
            margin-bottom: 10px;
        }

        .upload-instruction {
            font-weight: bold;
        }

        .upload-note {
            color: #999;
            font-size: 12px;
        }

        .status-label {
            font-weight: bold;
        }

        .status-value {
            color: #666;
        }

        .btn-disabled {
            pointer-events: none;
            opacity: 0.6;
        }

        #file-name {
            margin: 10px 0;
            font-weight: bold;
            color: #333;
            word-break: break-all;
        }

        #process-btn {
            margin-top: 10px;
            display: none;
            width: 100%;
        }

        .progress {
            margin-top: 15px;
            display: none;
        }

        .alert {
            margin-top: 15px;
            display: none;
        }

        .file-info-container {
            margin-top: 10px;
        }

        .upload-container {
            display: flex;
            flex-direction: column;
            height: 100%;
        }
    </style>

    <div class="card card-outline card-warning m-0">
        <div class="card-header">
            <h5 class=""><strong>DATA SUBDIREKTORAT OPERASI DAN PENGUNGKAPAN JARINGAN</strong></h5>
        </div>
        <div class="card-body">
            <div class="card-custom">
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-6">
                        <div class="upload-container">
                            <div id="drop-area" class="upload-box">
                                <div class="upload-icon">
                                    <img src="/images/upload_icon.png" alt="">
                                </div>
                                <div class="upload-instruction">
                                    Drag & drop files or <span class="text-orange">Browse</span>
                                </div>
                                <div class="upload-note">
                                    format yang didukung: .xlsx and .xls maksimal 5MB
                                </div>
                                <?= Html::beginForm(['jaringan/process'], 'post', [
                                    'enctype' => 'multipart/form-data',
                                    'id' => 'upload-form'
                                ]) ?>
                                <?= Html::fileInput('file', null, ['id' => 'file-input', 'style' => 'display:none']) ?>
                                <?= Html::endForm() ?>
                            </div>
                            
                            <div class="file-info-container">
                                <div id="file-name"></div>
                                <div id="progress-container" class="progress">
                                    <div id="progress-bar" class="progress-bar progress-bar-striped active" role="progressbar" style="width: 0%">
                                        <span id="progress-text">0%</span>
                                    </div>
                                </div>
                                <div id="alert-message" class="alert"></div>
                                <?= Html::button('Process', [
                                    'class' => 'btn btn-primary',
                                    'id' => 'process-btn'
                                ]) ?>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-md-6">
                        <p><strong>Terakhir diperbarui</strong> &nbsp; <?= $lastUpdated ?? '-' ?></p>
                        <p><strong>Import Status</strong></p>
                        <ul class="list-unstyled">
                            <li><span class="status-label">Total Kasus</span> &nbsp; <span id="total-kasus" class="status-value"><?= $totalKasus ? '<span class="text-success"><i class="fas fa-check-circle"></i></span>'  : '<span id="potensi-hemat" class="status-value">Belum ada data diunggah</span>' ?></span></li>
                            <li><span class="status-label">Total Berat</span> &nbsp; <span id="total-berat" class="status-value"><?= $totalBerat ? '<span class="text-success"><i class="fas fa-check-circle"></i></span>'  : '<span id="potensi-hemat" class="status-value">Belum ada data diunggah</span>'  ?></span></li>
                            <li><span class="status-label">Potensi Penghematan Negara</span> &nbsp; <?= $totalHemat ? '<span class="text-success"><i class="fas fa-check-circle"></i></span>'  : '<span id="potensi-hemat" class="status-value">Belum ada data diunggah</span>'  ?> </li>
                            <li><span class="status-label">Jenis NPP</span> &nbsp; <span id="jenis-npp" class="status-value">Belum ada data diunggah</span></li>
                            <li><span class="status-label">Moda Penyelundupan</span> &nbsp; <span id="moda-penyelundupan" class="status-value"><?= $moda ? '<span class="text-success"><i class="fas fa-check-circle"></i></span>'  : '<span id="potensi-hemat" class="status-value">Belum ada data diunggah</span>'  ?></span></li>
                            <li><span class="status-label">Data Penindakan</span> &nbsp; <span id="data-penindakan" class="status-value">Belum ada data diunggah</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    $script = <<<JS
    const dropArea = document.getElementById('drop-area');
    const fileInput = document.getElementById('file-input');
    const fileNameDisplay = document.getElementById('file-name');
    const processBtn = document.getElementById('process-btn');
    const progressContainer = document.getElementById('progress-container');
    const progressBar = document.getElementById('progress-bar');
    const progressText = document.getElementById('progress-text');
    const alertMessage = document.getElementById('alert-message');

    function isExcel(file) {
        const allowedTypes = ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
        const allowedExt = ['.xls', '.xlsx'];
        const fileExt = file.name.slice(file.name.lastIndexOf('.')).toLowerCase();
        return allowedTypes.includes(file.type) || allowedExt.includes(fileExt);
    }

    function handleFile(file) {
        if (!isExcel(file)) {
            showAlert('Hanya file Excel (.xls, .xlsx) yang diperbolehkan.', 'danger');
            resetFileInput();
            return;
        }

        if (file.size > 50 * 1024 * 1024) {
            showAlert('Ukuran file terlalu besar. Maksimal 5MB.', 'danger');
            resetFileInput();
            return;
        }

        fileNameDisplay.textContent = file.name;
        processBtn.style.display = 'block'; // Changed to block to take full width
        hideAlert();
    }

    function showAlert(message, type) {
        alertMessage.textContent = message;
        alertMessage.className = 'alert alert-' + (type || 'danger');
        alertMessage.style.display = 'block';
    }

    function hideAlert() {
        alertMessage.style.display = 'none';
    }

    function resetFileInput() {
        fileInput.value = '';
        fileNameDisplay.textContent = '';
        processBtn.style.display = 'none';
    }

    function processFile(e) {
        if (e) e.preventDefault();

        if (!fileInput.files.length) {
            showAlert('Silakan pilih file terlebih dahulu.', 'danger');
            return;
        }

        const formData = new FormData();
        formData.append('file', fileInput.files[0]);

        progressContainer.style.display = 'block';
        processBtn.disabled = true;
        processBtn.classList.add('btn-disabled');

        let progressPercent = 0;
        updateProgress(0);

        // Dummy progress increase tiap 1 detik, naik sampai max 90%
        const maxDummyProgress = 90;
        const maxTime = 30; // detik (5 menit)
        const increment = maxDummyProgress / maxTime; // % per detik

        const dummyInterval = setInterval(() => {
            if (progressPercent < maxDummyProgress) {
                progressPercent += increment;
                updateProgress(Math.floor(progressPercent));
            }
        }, 1000);

        $.ajax({
            url: '/report/process',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            xhr: function() {
                const xhr = new XMLHttpRequest();

                xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                        const percentComplete = Math.round((e.loaded / e.total) * 100);
                        // Prioritaskan progress upload di awal
                        updateProgress(percentComplete);
                        progressPercent = percentComplete; // update tracker
                    }
                }, false);

                return xhr;
            },
            success: function(response) {
                clearInterval(dummyInterval); // stop dummy progress

                if (response.success) {
                    showAlert('File berhasil diproses: ' + response.message, 'success');
                    updateStatus(response.data);
                } else {
                    showAlert('Error: ' + response.message, 'danger');
                }
            },
            error: function(xhr, status, error) {
                clearInterval(dummyInterval);
                showAlert('Terjadi kesalahan: ' + error, 'danger');
            },
            complete: function() {
                updateProgress(100);
                processBtn.disabled = false;
                processBtn.classList.remove('btn-disabled');

                setTimeout(() => {
                    progressContainer.style.display = 'none';
                    resetFileInput();
                }, 2000);
            }
        });
    }


    function updateProgress(percent) {
        progressBar.style.width = percent + '%';
        progressText.textContent = percent + '%';
    }

    function updateStatus(data) {
        if (data && data.total_kasus) {
            document.getElementById('total-kasus').textContent = data.total_kasus;
        }
        if (data && data.total_berat) {
            document.getElementById('total-berat').textContent = data.total_berat;
        }
        // Update other status fields similarly
    }

    // Event listeners
    dropArea.addEventListener('click', function(e) {
        if (e.target === dropArea || e.target.className.includes('upload-instruction') || e.target.className.includes('upload-icon')) {
            fileInput.click();
        }
    });

    processBtn.addEventListener('click', processFile);

    fileInput.addEventListener('change', function() {
        if (fileInput.files.length > 0) {
            handleFile(fileInput.files[0]);
        }
    });

    dropArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        dropArea.classList.add('dragover');
    });

    dropArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        dropArea.classList.remove('dragover');
    });

    dropArea.addEventListener('drop', function(e) {
        e.preventDefault();
        dropArea.classList.remove('dragover');

        const files = e.dataTransfer.files;
        if (files.length > 0) {
            handleFile(files[0]);
        }
    });
    JS;

    $this->registerJs($script);
    ?>