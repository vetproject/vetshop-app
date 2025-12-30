<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<?php
$configFile = __DIR__ . '../../../../models/settingTelegram.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $botToken = trim($_POST['botToken']);
    $chatId   = trim($_POST['chatId']);

    // Overwrite file with new settings
    $newConfig = "<?php\nreturn " . var_export([
        'botToken' => $botToken,
        'chatId'   => $chatId,
    ], true) . ";\n";

    file_put_contents($configFile, $newConfig);
    $message = "✅ Settings updated successfully!";
}

// Load current settings
$config = include $configFile;
?>

<form method="POST" class="settings-form" id="telegramSettingsForm">
    <div class="form-group">
        <label for="botToken">Bot Token:</label>
        <input type="password" name="botToken" id="botToken" value="<?= htmlspecialchars($config['botToken']) ?>">
    </div>

    <div class="form-group">
        <label for="chatId">Chat ID:</label>
        <input type="password" name="chatId" id="chatId" value="<?= htmlspecialchars($config['chatId']) ?>">
    </div>

    <button type="button" class="save-button" onclick="openModal()">💾 Save Settings</button>
</form>

<!-- Confirmation Modal -->
<div class="form-confirm" id="confirmModal">
    <div class="form-content">
        <span class="close-popup" id="closeConfirm">&times;</span>
        <h2>Are you sure you want to save?</h2>
        <div class="form-actions">
            <button type="button" id="cancelBtn" class="modal-btn cancel">No</button>
            <button type="button" id="confirmSaveBtn" class="modal-btn confirm">Yes</button>
        </div>
    </div>
</div>

<!-- Styles -->
<style>
    /* Modal Wrapper */
    .form-confirm {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
    }

    .form-confirm.show {
        display: flex;
    }

    /* Modal Box */
    .form-content {
        background-color: #fff;
        padding: 30px 25px;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        width: 90%;
        max-width: 400px;
        position: relative;
        text-align: center;
    }

    /* Close (X) */
    .close-popup {
        position: absolute;
        top: 12px;
        right: 15px;
        font-size: 24px;
        color: #888;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .close-popup:hover {
        color: #000;
    }

    /* Modal Buttons */
    .form-actions {
        margin-top: 25px;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .modal-btn {
        padding: 10px 20px;
        border-radius: 5px;
        font-weight: bold;
        border: none;
        cursor: pointer;
        font-size: 15px;
        transition: all 0.3s ease;
        width: 30%;
    }

    .modal-btn.cancel {
        background-color: #ccc;
        color: #333;
    }

    .modal-btn.cancel:hover {
        background-color: #bbb;
    }

    .modal-btn.confirm {
        background-color: #662D91;
        color: #fff;
    }

    .modal-btn.confirm:hover {
        background-color: #ad7bd3ff;
    }

    /* Form Styles */
    .settings-form {
        max-width: 500px;
        background: #fff;
        padding: 25px 50px 25px 25px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        font-weight: 500;
        margin-bottom: 8px;
        color: #444;
    }

    input[type="password"] {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 15px;
        transition: border-color 0.3s ease;
    }

    input[type="password"]:focus {
        border-color: #007bff;
        outline: none;
    }

    .save-button {
        background-color: #662D91;
        color: white;
        border: none;
        padding: 10px 20px;
        font-size: 15px;
        font-weight: 600;
        border-radius: 6px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .save-button:hover {
        background-color: #662D91;
    }
</style>

<!-- Script -->
<script>
    const confirmModal = document.getElementById('confirmModal');
    const closeConfirm = document.getElementById('closeConfirm');
    const cancelBtn = document.getElementById('cancelBtn');
    const confirmSaveBtn = document.getElementById('confirmSaveBtn');
    const form = document.getElementById('telegramSettingsForm');

    function openModal() {
        confirmModal.classList.add('show');
    }

    function closeModal() {
        confirmModal.classList.remove('show');
    }

    closeConfirm.onclick = closeModal;
    cancelBtn.onclick = closeModal;

    confirmSaveBtn.onclick = function() {
        form.submit();
    }

    window.onclick = function(event) {
        if (event.target === confirmModal) {
            closeModal();
        }
    }
</script>