<?php
/**
 * File: CustomerController.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-19
 * Copyright (c) 2019
 */

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AttachCustomerRequest;
use App\Http\Requests\Api\StoreCustomerRequest;
use App\Http\Requests\Api\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Repository\CustomerRepository;
use App\Repository\PersonRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class CustomerController
 * @package App\Http\Controllers\Api
 */
class CustomerController extends Controller
{
    /**
     * @var PersonRepository
     */
    private $personRepository;

    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    /**
     * CustomerController constructor.
     * @param CustomerRepository $customerRepository
     * @param PersonRepository $personRepository
     */
    public function __construct(CustomerRepository $customerRepository, PersonRepository $personRepository)
    {
        $this->customerRepository = $customerRepository;
        $this->personRepository = $personRepository;
    }

    /**
     * @param StoreCustomerRequest $request
     * @return CustomerResource
     */
    public function store(StoreCustomerRequest $request): CustomerResource
    {
        /** @var Customer $customer */
        $customer = DB::transaction(function () use ($request) {
            $person = $this->personRepository->create($request->getPersonDto());
            return $this->customerRepository->create($person);
        });
        $customer->load('person');

        return new CustomerResource($customer);
    }

    /**
     * @param AttachCustomerRequest $request
     * @return CustomerResource
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function createFromPerson(AttachCustomerRequest $request): CustomerResource
    {
        $dto = $request->getDto();
        $person = $this->personRepository->find($dto->person_id);
        $customer = $this->customerRepository->create($person);
        $customer->load('person');

        return new CustomerResource($customer);
    }

    /**
     * @param int $id
     * @return CustomerResource
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function show(int $id): CustomerResource
    {
        $customer = $this->customerRepository->find($id);
        $customer->load('person');

        return new CustomerResource($customer);
    }

    /**
     * @param int $id
     * @param UpdateCustomerRequest $request
     * @return CustomerResource
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function update(int $id, UpdateCustomerRequest $request): CustomerResource
    {
        $customer = $this->customerRepository->find($id);
        $this->customerRepository->update($customer, $request->getDto());
        $customer->load('person');

        return new CustomerResource($customer);
    }

    /**
     * @param int $id
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Exception
     */
    public function destroy(int $id): void
    {
        $customer = $this->customerRepository->find($id);
        $this->customerRepository->delete($customer);
    }
}
