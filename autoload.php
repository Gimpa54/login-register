<?php
$cacheFile = __DIR__ . '/namespace_map.json';
$namespaceMap = [];
$rootDirs = ['app', 'core', 'lib'];

function buildNamespaceMap(array $rootDirs): array {
    $map = [];

    foreach ($rootDirs as $root) {
        $fullPath = __DIR__ . '/' . $root;
        if (!is_dir($fullPath)) continue;

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($fullPath, FilesystemIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $fileInfo) {
            if ($fileInfo->isDir()) {
                $relativePath = str_replace(['\\', '/'], '/', substr($fileInfo->getPathname(), strlen(__DIR__) + 1));
                $namespace = str_replace('/', '\\', $relativePath);
                $relativePath = str_replace(['\\', '/'], '/', substr($fileInfo->getPathname(), strlen(__DIR__) + 1));
                
                // Rimuove 'app/', 'core/', 'lib/' dal path
                $relativePath = preg_replace('#^(app|core|lib)/#i', '', $relativePath);
                
                // Namespace finale corretto
                $namespace = 'App\\' . trim(str_replace('/', '\\', $relativePath), '\\') . '\\';
                

                if (!isset($map[$namespace])) {
                    $map[$namespace] = $fileInfo->getPathname() . '/';
                }
            }
        }
    }

    $map['App\\'] = __DIR__ . '/app/';
    return $map;
}

// Permette rigenerazione via URL
if (php_sapi_name() !== 'cli' && isset($_GET['regen']) && $_GET['regen'] == 1) {
    if (file_exists($cacheFile)) unlink($cacheFile);
}

// Usa cache o crea mappa
if (file_exists($cacheFile)) {
    $namespaceMap = json_decode(file_get_contents($cacheFile), true);
} else {
    $namespaceMap = buildNamespaceMap($rootDirs);
    file_put_contents($cacheFile, json_encode($namespaceMap, JSON_PRETTY_PRINT));
}

// Autoloader
spl_autoload_register(function ($class) use ($namespaceMap) {
    $class = ltrim($class, '\\');

    foreach ($namespaceMap as $prefix => $baseDir) {
        if (strpos($class, $prefix) === 0) {
            $relativeClass = substr($class, strlen($prefix));
            $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

            if (file_exists($file)) {
                require_once $file;
                return;
            }
        }
    }

    // Fallback directories
    foreach ([__DIR__ . '/app/', __DIR__ . '/core/', __DIR__ . '/lib/'] as $dir) {
        $file = $dir . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }

    error_log("[AUTOLOAD] Classe non trovata: $class");
});

// Helpers se esistono
$helperFile = __DIR__ . '/app/helpers/helpers.php';
if (file_exists($helperFile)) {
    require_once $helperFile;
}
