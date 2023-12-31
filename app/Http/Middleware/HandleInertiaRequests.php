<?php

namespace App\Http\Middleware;

use App\Http\Resources\LanguageResource;
use App\Lang\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'language' => app()->getLocale(),
            'translations' => function () {
                return cache()->remember('translations' . app()->getLocale(), now()->addMinutes(2), function () {
                    return collect(File::files(lang_path('/' . app()->getLocale())))->flatMap(function ($file) {
                        return Arr::dot(
                            File::getRequire($file->getRealPath()),
                            $file->getBasename($file->getExtension())
                        );
                    });
                });
            },
            'languages' => LanguageResource::collection(Language::cases()),
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
        ]);
    }
}
