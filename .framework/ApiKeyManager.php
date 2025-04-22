<?php declare(strict_types=1);

namespace PHPExperts\MiniApiBase;

use http\Exception\RuntimeException;
use Illuminate\Support\Facades\DB;

class ApiKeyManager
{
    public static function generateUuidV4(): string
    {
        $data = random_bytes(16);

        // Set the version to 0100
        $data[6] = chr((ord($data[6]) & 0x0f) | 0x40);

        // Set the variant to 10xx
        $data[8] = chr((ord($data[8]) & 0x3f) | 0x80);

        // Convert to hexadecimal and format as UUID
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    public function createApiKey(string $client): string
    {
        $apiKey = self::generateUuidV4();
        $wasSuccessful = DB::table('api_keys')
            ->insert([
                'apikey' => $apiKey,
                'client' => $client
            ]);
        if ($wasSuccessful === false) {
            throw new RuntimeException('Could not create an API key.');
        }

        return $apiKey;
    }

    public function activateKey(string $apikey)
    {
        DB::table('api_keys')
            ->where('apikey', $apikey)
            ->update(['is_active' => true]);
    }

    public function deactivateKey(string $apikey)
    {
        DB::table('api_keys')
            ->where('apikey', $apikey)
            ->update(['is_active' => false]);
    }
}
