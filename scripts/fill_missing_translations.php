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

// Lingue da supportare
$languages = ['it', 'en', 'de', 'es', 'fr', 'pt'];

$filledCount = 0;

function fillKey(&$value, $languages, &$filledCount)
{
    if (is_array($value) && array_keys($value) === $languages) {
        // Se è un nodo di traduzioni
        foreach ($languages as $lang) {
            if (!isset($value[$lang]) || trim($value[$lang]) === '') {
                $value[$lang] = $value['it'] ?? '';
                $filledCount++;
            }
        }
    } else {
        // Nodo annidato
        foreach ($value as &$subValue) {
            if (is_array($subValue)) {
                fillKey($subValue, $languages, $filledCount);
            }
        }
    }
}

foreach ($data as &$value) {
    fillKey($value, $languages, $filledCount);
}

if ($filledCount > 0) {
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    echo "✅ Traduzioni mancanti riempite automaticamente ($filledCount campi aggiornati).\n";
} else {
    echo "✅ Nessuna traduzione mancante trovata.\n";
}

