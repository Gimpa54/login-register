<?php
/**
 * CLI script: rigenera la mappa delle classi
 * Usa: php generate_map.php
 */
$rootDirs = ['app', 'core', 'lib'];
$cacheFile = __DIR__ . '/namespace_map.json';

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
                $namespace = trim($namespace, '\\') . '\\';
                
                if (!isset($map[$namespace])) {
                    $map[$namespace] = $fileInfo->getPathname() . '/';
                }
            }
        }
    }
    
    $map['App\\'] = __DIR__ . '/app/';
    return $map;
}

$map = buildNamespaceMap($rootDirs);
file_put_contents($cacheFile, json_encode($map, JSON_PRETTY_PRINT));
echo "✅ Mappa namespace rigenerata in $cacheFile\n";

