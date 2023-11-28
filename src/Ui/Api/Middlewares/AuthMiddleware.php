<?php

declare(strict_types=1);

namespace Core\Ui\Api\Middlewares;

use Core\Domain\Account\Repository\AccountRepositoryInterface;
use Core\Ui\Api\Adapter\Http\HttpResponseAdapter;
use Core\Ui\Api\Adapter\Http\HttpResponseHelper;
use Core\Ui\Api\MiddlewareInterface;

class AuthMiddleware implements MiddlewareInterface
{
    public function __construct(private readonly AccountRepositoryInterface $accountRepository)
    {
    }

    public function __invoke(object $request): HttpResponseAdapter
    {
        try {
            if ( isset($request->Authorization) ) {
                $accessToken = $this->removeBearer($request->Authorization[0]);
                $account = $this->accountRepository->loadByToken(token: $accessToken);
                if ($account) {
                    return HttpResponseHelper::ok(['userId' => $account->id()]);
                }
            }

            return HttpResponseHelper::forbidden('Access Denied');
        } catch (\Exception $exception) {
            return HttpResponseHelper::serverError();
        }
    }

    private function removeBearer(string $token): string
    {
        $accessToken = $token;
        if ( str_starts_with($accessToken, 'Bearer ') ) {
            $accessToken = substr($accessToken, 7);
        }
        return $accessToken;
    }
}