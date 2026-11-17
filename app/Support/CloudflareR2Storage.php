<?php

namespace App\Support;

use Carbon\CarbonImmutable;
use Illuminate\Support\Str;

class CloudflareR2Storage
{
    public function isConfigured(): bool
    {
        return $this->endpoint() !== ''
            && $this->accessKeyId() !== ''
            && $this->secretAccessKey() !== ''
            && $this->bucket() !== '';
    }

    public function endpoint(): string
    {
        $endpoint = config('filesystems.disks.r2.endpoint');

        if (is_string($endpoint) && trim($endpoint) !== '') {
            return rtrim(trim($endpoint), '/');
        }

        $accountId = config('filesystems.disks.r2.account_id');

        if (is_string($accountId) && trim($accountId) !== '') {
            return 'https://'.trim($accountId).'.r2.cloudflarestorage.com';
        }

        return '';
    }

    public function bucket(): string
    {
        $bucket = config('filesystems.disks.r2.bucket');

        return is_string($bucket) ? trim($bucket) : '';
    }

    public function region(): string
    {
        $region = config('filesystems.disks.r2.region');

        return is_string($region) && trim($region) !== '' ? trim($region) : 'auto';
    }

    public function generateReportKey(int $userId, string $originalName): string
    {
        $baseName = pathinfo($originalName, PATHINFO_FILENAME);
        $slug = Str::slug($baseName) ?: 'laporan';
        $slug = Str::limit($slug, 48, '');

        return sprintf('reports/%d/%s-%s.pdf', $userId, now()->format('YmdHis'), $slug.'-'.Str::lower(Str::random(8)));
    }

    public function isValidUserReportKey(int $userId, string $key): bool
    {
        return preg_match('/^reports\/'.preg_quote((string) $userId, '/').'\/[a-zA-Z0-9._-]+\.pdf$/', $key) === 1;
    }

    public function presignPutUrl(string $key, int $expiresSeconds = 900, ?CarbonImmutable $now = null): string
    {
        return $this->presign('PUT', $key, $expiresSeconds, $now);
    }

    public function presignGetUrl(string $key, int $expiresSeconds = 600, ?CarbonImmutable $now = null): string
    {
        return $this->presign('GET', $key, $expiresSeconds, $now);
    }

    public function presign(string $method, string $key, int $expiresSeconds = 600, ?CarbonImmutable $now = null): string
    {
        if (! $this->isConfigured()) {
            throw new \RuntimeException('Cloudflare R2 storage is not configured.');
        }

        $endpoint = $this->endpoint();
        $parsed = parse_url($endpoint);

        if (! is_array($parsed) || ! isset($parsed['host'])) {
            throw new \RuntimeException('Invalid Cloudflare R2 endpoint URL.');
        }

        $host = $parsed['host'].(isset($parsed['port']) ? ':'.$parsed['port'] : '');
        $timestamp = ($now ?? CarbonImmutable::now('UTC'))->setTimezone('UTC');
        $amzDate = $timestamp->format('Ymd\THis\Z');
        $dateStamp = $timestamp->format('Ymd');
        $region = $this->region();
        $scope = "{$dateStamp}/{$region}/s3/aws4_request";

        $segments = array_map(
            static fn (string $segment): string => rawurlencode($segment),
            array_values(array_filter(explode('/', ltrim($key, '/')), static fn (string $part): bool => $part !== '')),
        );
        $canonicalUri = '/'.rawurlencode($this->bucket()).'/'.implode('/', $segments);

        $query = [
            'X-Amz-Algorithm' => 'AWS4-HMAC-SHA256',
            'X-Amz-Credential' => $this->accessKeyId().'/'.$scope,
            'X-Amz-Date' => $amzDate,
            'X-Amz-Expires' => (string) max(1, min(604800, $expiresSeconds)),
            'X-Amz-SignedHeaders' => 'host',
        ];
        ksort($query);

        $canonicalQuery = http_build_query($query, '', '&', PHP_QUERY_RFC3986);
        $canonicalRequest = implode("\n", [
            strtoupper($method),
            $canonicalUri,
            $canonicalQuery,
            "host:{$host}",
            '',
            'host',
            'UNSIGNED-PAYLOAD',
        ]);

        $stringToSign = implode("\n", [
            'AWS4-HMAC-SHA256',
            $amzDate,
            $scope,
            hash('sha256', $canonicalRequest),
        ]);

        $signingKey = $this->signingKey($dateStamp, $region);
        $signature = hash_hmac('sha256', $stringToSign, $signingKey);

        return $endpoint.$canonicalUri.'?'.$canonicalQuery.'&X-Amz-Signature='.$signature;
    }

    private function accessKeyId(): string
    {
        $key = config('filesystems.disks.r2.key');

        return is_string($key) ? trim($key) : '';
    }

    private function secretAccessKey(): string
    {
        $secret = config('filesystems.disks.r2.secret');

        return is_string($secret) ? trim($secret) : '';
    }

    private function signingKey(string $dateStamp, string $region): string
    {
        $dateKey = hash_hmac('sha256', $dateStamp, 'AWS4'.$this->secretAccessKey(), true);
        $regionKey = hash_hmac('sha256', $region, $dateKey, true);
        $serviceKey = hash_hmac('sha256', 's3', $regionKey, true);

        return hash_hmac('sha256', 'aws4_request', $serviceKey, true);
    }
}
