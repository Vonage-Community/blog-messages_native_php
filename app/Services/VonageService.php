<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Vonage\Client;
use Vonage\Client\Credentials\Keypair;

class VonageService
{
    protected Client $client;

    public function __construct()
    {
        $applicationId = config('services.vonage.application_id');
        $privateKeyPath = config('services.vonage.private_key_path', 'private.key');

        $path = $this->resolvePrivateKeyPath($privateKeyPath);

        if (! File::exists($path) || ! File::isFile($path)) {
            throw new \InvalidArgumentException("Vonage private key file not found: {$path}");
        }

        $privateKey = File::get($path);

        $credentials = new Keypair($privateKey, $applicationId);
        $this->client = new Client($credentials);
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * Resolve private key path: relative paths are from project root.
     */
    protected function resolvePrivateKeyPath(string $path): string
    {
        if ($path === '' || $path === '0') {
            return base_path('private.key');
        }

        if ($this->isAbsolutePath($path)) {
            return $path;
        }

        return base_path($path);
    }

    protected function isAbsolutePath(string $path): bool
    {
        if (str_starts_with($path, '/')) {
            return true;
        }

        if (PHP_OS_FAMILY === 'Windows' && preg_match('#^[A-Za-z]:[\\\\/]#', $path)) {
            return true;
        }

        return false;
    }
}
