<?php
namespace App\Utils;

class Uploader
{
    protected string $uploadDir;
    protected int $maxSize;
    protected array $allowedTypes;

    public function __construct(
        string $folder = 'storage/uploads',
        int $maxSizeMB = null,
        array $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'application/pdf']
    ) {
        // Percorso reale sulla macchina (public/ + percorso relativo)
        $folder = ltrim($folder, '/');
        $this->uploadDir = __DIR__ . '/../../public/' . rtrim($folder, '/');

        // Max size in byte
        $this->maxSize = ($maxSizeMB ?? (int) env('MAX_UPLOAD_MB', 10)) * 1024 * 1024;
        $this->allowedTypes = $allowedTypes;
    }

    /**
     * Upload singolo file (può essere usato staticamente)
     */
    public static function upload(array $file, string $folder = 'storage/uploads', array $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'application/pdf'], int $maxSizeMB = null): ?string
    {
        $instance = new self($folder, $maxSizeMB, $allowedTypes);
        return $instance->doUpload($file);
    }

    /**
     * Upload multiplo (può essere usato staticamente)
     */
    public static function uploadMultiple(array $files, string $folder = 'storage/uploads', array $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'application/pdf'], int $maxSizeMB = null): array
    {
        $instance = new self($folder, $maxSizeMB, $allowedTypes);
        return $instance->doUploadMultiple($files);
    }

    /**
     * Logica reale di upload singolo
     */
    private function doUpload(array $file): ?string
    {
        if ($file['error'] !== UPLOAD_ERR_OK) return null;
        if (!in_array($file['type'], $this->allowedTypes)) return null;
        if ($file['size'] > $this->maxSize) return null;

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = $this->generateFilename($file['name'], $ext);
        $target = $this->uploadDir . '/' . $filename;

        // Crea la cartella se non esiste
        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0775, true);
        }

        // Sposta il file
        if (move_uploaded_file($file['tmp_name'], $target)) {
            return $filename;
        }

        return null;
    }

    /**
     * Logica reale di upload multiplo
     */
    private function doUploadMultiple(array $files): array
    {
        $uploaded = [];

        foreach ($files['tmp_name'] as $index => $tmp) {
            $file = [
                'name'     => $files['name'][$index],
                'type'     => $files['type'][$index],
                'tmp_name' => $tmp,
                'error'    => $files['error'][$index],
                'size'     => $files['size'][$index],
            ];

            $result = $this->doUpload($file);
            if ($result) {
                $uploaded[] = $result;
            }
        }

        return $uploaded;
    }

    protected function generateFilename(string $original, string $ext): string
    {
        $name = pathinfo($original, PATHINFO_FILENAME);
        $slug = preg_replace('/[^a-z0-9]+/i', '-', strtolower($name));
        $slug = trim($slug, '-');
        return $slug . '-' . uniqid() . '.' . $ext;
    }
}
