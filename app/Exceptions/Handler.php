<?php
declare(strict_types=1);

namespace App\Exceptions;

use App\Exceptions\Auth\UnauthorizedException;
use App\Services\Login\Exceptions\UserNotFoundException;
use App\Services\Login\Exceptions\WrongPasswordException;
use App\Services\User\Exceptions\OldPasswordInvalidException;
use App\Services\UserRegister\Exceptions\UserAlreadyRegisteredWithOtherPhoneNumber;
use App\Services\UserRegister\Exceptions\UserAlreadyRegisteredWithSamePhoneNumber;
use App\Services\Verify\Exceptions\TextMessageSendingFailed;
use App\Services\Verify\Exceptions\VerificationCodeAlreadySentRecently;
use App\Services\Verify\Exceptions\VerificationCodeIsInvalid;
use App\Services\Verify\Exceptions\VerificationCodeWasSentTooManyTimes;

/**
 * Class Handler
 * @package App\Exceptions
 */
class Handler extends BaseExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     * @var array
     */
    protected $dontReport = array(
        UnauthorizedException::class,
        UserNotFoundException::class,
        WrongPasswordException::class,
        OldPasswordInvalidException::class,
        UserAlreadyRegisteredWithSamePhoneNumber::class,
        UserAlreadyRegisteredWithOtherPhoneNumber::class,
        VerificationCodeIsInvalid::class,
        VerificationCodeWasSentTooManyTimes::class,
        VerificationCodeAlreadySentRecently::class,
        TextMessageSendingFailed::class,
        UserHasNoPersonException::class,
    );

    /**
     * Returns a list of user-defined exception handlers
     * Feel free to put your handlers here, and also you can override internal handlers here
     * @return array
     */
    protected function getCustomHandlers(): array
    {
        return [
            UnauthorizedException::class => [$this, 'renderAsJson'],
            UserNotFoundException::class => [$this, 'renderAsJson'],
            WrongPasswordException::class => [$this, 'renderAsJson'],
            OldPasswordInvalidException::class => [$this, 'renderAsJson'],
            UserAlreadyRegisteredWithSamePhoneNumber::class => [$this, 'renderAsJson'],
            UserAlreadyRegisteredWithOtherPhoneNumber::class => [$this, 'renderAsJson'],
            VerificationCodeIsInvalid::class => [$this, 'renderAsJson'],
            VerificationCodeWasSentTooManyTimes::class => [$this, 'renderAsJson'],
            VerificationCodeAlreadySentRecently::class => [$this, 'renderAsJson'],
            TextMessageSendingFailed::class => [$this, 'renderAsJson'],
            UserHasNoPersonException::class => [$this, 'renderAsJson'],
        ];
    }

    /**
     * @param ReadableExceptionInterface $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function renderAsJson(ReadableExceptionInterface $exception): \Illuminate\Http\JsonResponse {
        $output = [
            'error' => $exception->getMessage(),
            'message' => \trans('exceptions.' . $exception->getMessage()),
        ];
        $payload = $exception->getData();
        if (null !== $payload) {
            $output['data'] = $payload;
        }

        return \json_response($output, $exception->getStatusCode());
    }
}
