<?php

namespace App\Http\Middleware;

use Closure;


class Cors
{
    /**
     * @param $request
     * @param Closure $next
     * @return void
     */
    public function handle($request, Closure $next)
    {
        return $next($request)
            ->header('access-control-allow-origin', config('app.url'))
            ->header('access-control-allow-methods', 'get, post, put, delete')
            ->header('access-control-allow-credentials', 'true') //CORSリクエストでクッキーは送信されたり、BASIC認証は送れる。
            ->header('access-control-allow-headers', 'content-type, accept, authorization, content-encoding')
            ->header('cache-control', 'private, no-cache, no-store, must-revalidate')
            ->header('accept-ch', 'sec-ch-prefers-color-scheme,viewport-width') //クライアントが受け入れる文字セットを指定します
            ->header('accept-ch-lifetime', '4838400')
            ->header('alt-svc', 'h3=":443"; ma=86400') //将来の HTTP 要求で利用できる代替ネットワーク
            ->header('priority', 'urgency=3, progressive=?1') //クライアントはこのHTTPリクエストの優先度をサーバに通知します。
            ->header('content-security-policy', config('app.csp_report'))
            ->header('content-security-policy-report-only', config('app.csp_report'))
            ->header('cross-origin-opener-policy', 'same-origin-allow-popups')
            ->header('cross-origin-resource-policy', 'same-origin')
            ->header('document-policy', 'force-load-at-top')
            ->header('strict-transport-security', 'max-age=15552000; preload')
            ->header('vary', 'Accept-Encoding')
            ->header('x-content-type-options:', 'nosniff')//iframe削除、Clickjacking防止
            ->header('x-xss-protection:', '1; mode=block')//Cross-Site Scripting (XSS)攻撃防止
            ->header('X-Powered-By', 'Secret')//PHP/7.4.30非表示
            ->header('pragma', 'no-cache')//具体的な指定
            ->header('cache-control', 'max-age=31536000');//具体的な指定
    }
}
