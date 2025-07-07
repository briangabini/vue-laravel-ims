<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * @param Request $request
     * @return RedirectResponse|JsonResponse
     */
    public function toResponse($request): JsonResponse|RedirectResponse
    {
        return $request->wantsJson()
            ? new JsonResponse(' ', 204)
            : $this->redirectUser($request);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    protected function redirectUser(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user && in_array($user->role->name, ['admin', 'manager'])) {
            return redirect()->intended(config('fortify.dashboard'));
        }

        return redirect()->intended(config('fortify.home'));
    }

}
