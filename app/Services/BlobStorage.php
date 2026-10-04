<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

/**
 * Minimal client for Vercel Blob (the same REST calls @vercel/blob's put() makes).
 */
class BlobStorage
{
    public function __construct(private ?string $token = null)
    {
        $this->token ??= config('services.blob.token');
    }

    public function enabled(): bool
    {
        return filled($this->token);
    }

    /** Upload a file and return its public URL. */
    public function put(string $pathname, string $contents, string $contentType): string
    {
        if (! $this->enabled()) {
            throw new RuntimeException('BLOB_READ_WRITE_TOKEN is not set.');
        }

        $storeId = explode('_', $this->token)[3] ?? '';

        $response = Http::withHeaders([
            'authorization' => 'Bearer '.$this->token,
            'x-api-version' => '12',
            'x-vercel-blob-store-id' => $storeId,
            'x-vercel-blob-access' => 'public',
            'x-content-type' => $contentType,
            'x-add-random-suffix' => '0',
            'x-allow-overwrite' => '1',
            'x-cache-control-max-age' => '31536000',
        ])
            ->withBody($contents, $contentType)
            ->timeout(60)
            ->retry(2, 500, throw: false)
            ->put(config('services.blob.api_url').'/?'.http_build_query(['pathname' => $pathname]));

        if (! $response->successful()) {
            throw new RuntimeException('Blob upload failed: '.$response->status().' '.$response->body());
        }

        return $response->json('url');
    }
}
