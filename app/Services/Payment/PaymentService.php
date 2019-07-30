<?php
/**
 * File: PaymentService.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-28
 * Copyright (c) 2019
 */

declare(strict_types=1);

namespace App\Services\Payment;

use App\Models\Instructor;
use App\Models\Lesson;
use App\Models\Payment;
use App\Models\Student;
use App\Models\User;
use App\Models\Visit;
use App\Repository\PaymentRepository;
use App\Services\Account\AccountService;

/**
 * Class PaymentService
 * @package App\Services\Payment
 */
class PaymentService
{
    /**
     * @var PaymentRepository
     */
    private $repository;

    /**
     * @var AccountService
     */
    private $accountService;

    /**
     * PaymentService constructor.
     * @param PaymentRepository $repository
     * @param AccountService $accountService
     */
    public function __construct(PaymentRepository $repository, AccountService $accountService)
    {
        $this->repository = $repository;
        $this->accountService = $accountService;
    }

    /**
     * @param int $price
     * @param Visit $visit
     * @param Student $student
     * @param User|null $user
     * @return Payment
     * @throws \App\Services\Account\Exceptions\InsufficientFundsAccountServiceException
     * @throws \Exception
     */
    public function createVisitPayment(int $price, Visit $visit, Student $student, ?User $user = null): Payment
    {
        $dto = new \App\Repository\DTO\Payment;
        $dto->type = Payment::TYPE_AUTOMATIC;
        $dto->amount = $price;
        $dto->name = \trans('payment.name_presets.visit', ['lesson' => $visit->event->name]);
        $dto->object_type = Visit::class;
        $dto->object_id = $visit->id;
        $dto->user_id = $user ? $user->id : null;

        $studentAccount = $this->accountService->getStudentAccount($student);
        $savingsAccount = $this->accountService->getSavingsAccount($visit->event->branch);

        $this->accountService->checkFunds($studentAccount, $price);

        [$outgoing, $incoming] = $this->repository->createInternalTransaction($dto, $studentAccount, $savingsAccount);

        return $incoming;
    }

    /**
     * @param int $price
     * @param Lesson $lesson
     * @param Instructor $instructor
     * @param User|null $user
     * @return Payment
     * @throws \Exception
     */
    public function createLessonPayment(int $price, Lesson $lesson, Instructor $instructor, ?User $user = null): Payment
    {
        $dto = new \App\Repository\DTO\Payment;
        $dto->type = Payment::TYPE_AUTOMATIC;
        $dto->amount = $price;
        $dto->name = \trans('payment.name_presets.lesson', ['lesson' => $lesson->name]);
        $dto->object_type = Lesson::class;
        $dto->object_id = $lesson->id;
        $dto->user_id = $user ? $user->id : null;

        $savingsAccount = $this->accountService->getSavingsAccount($lesson->branch);
        $instructorAccount = $this->accountService->getInstructorAccount($instructor);

        [$outgoing, $incoming] = $this->repository->createInternalTransaction($dto, $savingsAccount,
            $instructorAccount);

        return $outgoing;
    }
}
