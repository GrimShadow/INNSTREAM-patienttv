<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IpWhitelistMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only apply IP whitelisting in production
        if (app()->environment('production')) {
            $allowedIps = config('cors.allowed_ips', []);
            $clientIp = $this->getClientIp($request);

            // Allow localhost and private networks in production
            $privateRanges = [
                '127.0.0.1',
                '::1',
                '192.168.0.0/16',
                '10.0.0.0/8',
                '172.16.0.0/12',
            ];

            $isAllowed = in_array($clientIp, $allowedIps) ||
                        $this->isIpInRanges($clientIp, $privateRanges);

            if (! $isAllowed) {
                return response()->json([
                    'success' => false,
                    'message' => 'Access denied from this IP address',
                    'error' => 'IP_NOT_ALLOWED',
                ], 403);
            }
        }

        return $next($request);
    }

    /**
     * Get the client's real IP address
     */
    private function getClientIp(Request $request): string
    {
        $headers = [
            'HTTP_CF_CONNECTING_IP',     // Cloudflare
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR',
        ];

        foreach ($headers as $header) {
            if (! empty($request->server($header))) {
                $ips = explode(',', $request->server($header));

                return trim($ips[0]);
            }
        }

        return $request->ip();
    }

    /**
     * Check if IP is in any of the given ranges
     */
    private function isIpInRanges(string $ip, array $ranges): bool
    {
        foreach ($ranges as $range) {
            if (strpos($range, '/') !== false) {
                // CIDR notation
                if ($this->ipInCidr($ip, $range)) {
                    return true;
                }
            } else {
                // Exact match
                if ($ip === $range) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Check if IP is in CIDR range
     */
    private function ipInCidr(string $ip, string $cidr): bool
    {
        [$subnet, $mask] = explode('/', $cidr);

        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return $this->ipv4InCidr($ip, $subnet, (int) $mask);
        }

        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            return $this->ipv6InCidr($ip, $subnet, (int) $mask);
        }

        return false;
    }

    /**
     * Check if IPv4 is in CIDR range
     */
    private function ipv4InCidr(string $ip, string $subnet, int $mask): bool
    {
        $ipLong = ip2long($ip);
        $subnetLong = ip2long($subnet);
        $maskLong = -1 << (32 - $mask);

        return ($ipLong & $maskLong) === ($subnetLong & $maskLong);
    }

    /**
     * Check if IPv6 is in CIDR range
     */
    private function ipv6InCidr(string $ip, string $subnet, int $mask): bool
    {
        $ipBin = inet_pton($ip);
        $subnetBin = inet_pton($subnet);

        if ($ipBin === false || $subnetBin === false) {
            return false;
        }

        $bytes = intval($mask / 8);
        $bits = $mask % 8;

        if ($bytes > 0) {
            if (substr($ipBin, 0, $bytes) !== substr($subnetBin, 0, $bytes)) {
                return false;
            }
        }

        if ($bits > 0) {
            $maskByte = 0xFF << (8 - $bits);
            $ipByte = ord($ipBin[$bytes]);
            $subnetByte = ord($subnetBin[$bytes]);

            if (($ipByte & $maskByte) !== ($subnetByte & $maskByte)) {
                return false;
            }
        }

        return true;
    }
}
