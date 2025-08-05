<?php
// Percorso al file messages.json
$file = __DIR__ . '/../langs/messages.json';

if (!file_exists($file)) {
    die("❌ File non trovato: $file\n");
}

$json = file_get_contents($file);
$data = json_decode($json, true);

if (!is_array($data)) {
    die("❌ Errore nel parsing del JSON.\n");
}

// Lingue richieste
$languages = ['it', 'en', 'de', 'es', 'fr', 'pt'];

$missing = [];

function checkKey($key, $value, $path = '', $languages = [], &$missing = [])
{
    if (is_array($value) && array_keys($value) === $languages) {
        // Controllo traduzioni per tutte le lingue
        foreach ($languages as $lang) {
            if (!isset($value[$lang]) || trim($value[$lang]) === '') {
                $missing[] = "$path ($lang mancante)";
            }
        }
    } else {
        // Caso di chiave annidata (es: validation.min_length)
        foreach ($value as $subKey => $subValue) {
            checkKey($subKey, $subValue, ($path ? "$path." : "") . $subKey, $languages, $missing);
        }
    }
}

foreach ($data as $key => $value) {
    checkKey($key, $value, $key, $languages, $missing);
}

if (empty($missing)) {
    echo "✅ Tutte le chiavi hanno le traduzioni complete in tutte le lingue.\n";
} else {
    echo "⚠️ Traduzioni mancanti:\n";
    foreach ($missing as $m) {
        echo "- $m\n";
    }
}

