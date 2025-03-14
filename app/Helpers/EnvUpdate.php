<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class EnvUpdate
{
    public static function set($key, $value)
    {
        try {
            $path = base_path('.env');

         
            if (!File::exists($path)) {
                throw new \Exception('.env file not found');
            }

            $env = File::get($path);

          
            if (strpos($env, "$key=") !== false) {
            
                $env = preg_replace("/^$key=.*$/m", "$key=$value", $env);
            } else {
           
                $env .= "\n$key=$value";
            }

           
            File::put($path, $env);

        
            Artisan::call('config:clear');
            Artisan::call('cache:clear');

            Log::info("Updated .env file: $key=$value");

        } catch (\Exception $e) {
            Log::error('Failed to update .env: ' . $e->getMessage());
        }
    }
}
