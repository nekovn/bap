<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     * @param Request $request
     * @see https://inertiajs.com/server-side-setup#root-template
     * @return string
     */
    public function rootView(Request $request)
    {
        if ($request->is(['admin', 'admin/*'])) {
            return 'admin.app';
        }

        return 'client.app';
    }

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'lang' => app()->getLocale(),
            'success' => $request->session()->get('success'),
            'errors' => $request->session()->get('errors')
        ]);
    }
}
