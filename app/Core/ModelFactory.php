<?php
namespace App\Core;

class ModelFactory
{
    public static function make(string $modelName): object
    {
        $modelClass = "App\\Models\\" . ucfirst($modelName);
        
        if (!class_exists($modelClass)) {
            throw new \Exception("Modello {$modelClass} non trovato");
        }
        
        return new $modelClass;
    }
}

