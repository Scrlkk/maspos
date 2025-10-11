<?php

namespace App\Http\Middleware;

use App\Models\Cart;
use Illuminate\Http\Request;
use Inertia\Middleware;

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
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'categories' => function () {
                return \App\Models\Category::all();
            },
            'cartData' => function () use ($request) {
                if ($request->user()) {
                    $carts = Cart::where('user_id', $request->user()->id)->get();
                    $total = $carts->sum('subtotal');
                    $count = $carts->sum('quantity');

                    return [
                        'total' => $total,
                        'count' => $count,
                    ];
                }

                return [
                    'total' => 0,
                    'count' => 0,
                ];
            },
        ];
    }
}
