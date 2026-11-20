<?php

namespace App\Support;

use App\Models\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Throwable;

/**
 * Turns a would-be 404 into a 301 when the address is known from the old site
 * or was added in the admin panel. Only runs for missing pages, so it costs nothing elsewhere.
 */
class Redirects
{
    public static function for(Request $request): ?RedirectResponse
    {
        if (! in_array($request->method(), ['GET', 'HEAD'])) {
            return null;
        }

        $path = Redirect::normalize($request->path());
        [$target, $status] = static::lookup($path) ?? [null, 301];

        if ($target === null || Redirect::normalize($target) === $path) {
            return null;
        }

        return redirect()->to($target, $status);
    }

    /** @return array{0: string, 1: int}|null */
    public static function lookup(string $path): ?array
    {
        try {
            if ($redirect = Redirect::where('from_path', $path)->first()) {
                $redirect->increment('hits');

                return [$redirect->to_path, $redirect->status_code ?: 301];
            }
        } catch (Throwable) {
            // redirects table not migrated yet
        }

        if ($target = config('redirects.paths')[$path] ?? null) {
            return [$target, 301];
        }

        foreach (config('redirects.patterns', []) as $pattern => $target) {
            if (preg_match($pattern, $path)) {
                return [preg_replace($pattern, $target, $path), 301];
            }
        }

        return null;
    }
}
