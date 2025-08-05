<?php
namespace App\Helpers;

use App\Utils\Uploader;
use App\Utils\Logger;

class AvatarHelper
{
    /**
     * Gestisce l'upload dell'avatar.
     * @param array $file       Il file $_FILES['avatar']
     * @param string $logFile   Nome file log (es. register.log o profile.log)
     * @param int $maxSizeMB    Dimensione massima in MB
     * @return string|null      Nome file salvato oppure null in caso di errore
     * @throws \Exception
     */
    public static function handle(array $file, string $logFile = 'avatar.log', int $maxSizeMB = 2): ?string
    {
        if (empty($file['name'])) {
            return null;
        }
        
        try {
            $uploaded = Uploader::upload(
                $file,
                'storage/avatars',
                ['image/jpeg', 'image/png', 'image/jpg'],
                $maxSizeMB
                );
            
            if ($uploaded) {
                Logger::debug("Avatar caricato con successo", ['avatar' => $uploaded], $logFile);
                return $uploaded;
            } else {
                Logger::error("Errore durante il caricamento dell'avatar", [], $logFile);
                return null;
            }
        } catch (\Exception $e) {
            Logger::error("Eccezione upload avatar", ['error' => $e->getMessage()], $logFile);
            return null;
        }
    }
}
