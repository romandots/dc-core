<?php
/**
 * File: CustomerTest.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-19
 * Copyright (c) 2019
 */
declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Traits\CreatesFakeCustomer;
use Tests\Traits\CreatesFakePerson;

/**
 * Class PersonTest
 */
class CustomerTest extends \Tests\TestCase
{
    use WithFaker, RefreshDatabase, CreatesFakePerson, CreatesFakeCustomer;

    protected const URL = '/api/customers';

    protected const JSON_STRUCTURE = [
        'data' => [
            'id',
            'name',
            'person',
            'contract',
            'seen_at',
            'created_at',
        ]
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->refreshDatabase();
    }

    public function testShow(): void
    {
        $customer = $this->createFakeCustomer();
        $person = $customer->person;

        $url = self::URL . '/' . $customer->id;

        $this
            ->get($url)
            ->assertOk()
            ->assertJson([
                'data' => [
                    'id' => $customer->id,
                    'name' => $customer->name,
                    'person' => [
                        'id' => $person->id,
                        'last_name' => $person->last_name,
                        'first_name' => $person->first_name,
                        'patronymic_name' => $person->patronymic_name,
                        'birth_date' => $person->birth_date->toDateString(),
                        'gender' => $person->gender,
                        'phone' => $person->phone,
                        'email' => $person->email,
                        'picture' => $person->picture,
                        'picture_thumb' => $person->picture_thumb,
                        'instagram_username' => $person->instagram_username,
                        'telegram_username' => $person->telegram_username,
                        'vk_uid' => $person->vk_uid,
                        'vk_url' => $person->vk_url,
                        'facebook_uid' => $person->facebook_uid,
                        'facebook_url' => $person->facebook_url,
                        'note' => $person->note,
                        'created_at' => $person->created_at->toDateTimeString()
                    ],
                    'seen_at' => $customer->seen_at->toDateTimeString(),
                    'created_at' => $customer->created_at->toDateTimeString()
                ]
            ]);
    }

    public function testStore(): void
    {
        $data = [
            'last_name' => 'Иванов',
            'first_name' => 'Иван',
            'patronymic_name' => 'Иванович',
            'birth_date' => '1986-06-15',
            'gender' => 'male',
            'phone' => '+7-999-999-99-99',
            'email' => 'some@email.com',
            'instagram_username' => 'instaperez',
            'telegram_username' => 'teleperez',
            'vk_url' => 'https://vk.com/durov',
            'facebook_url' => 'https://facebook.com/mark',
            'note' => 'Some testy note',
        ];

        $this
            ->post(self::URL, $data)
            ->assertStatus(201)
            ->assertJsonStructure(self::JSON_STRUCTURE)
            ->assertJson([
                'data' => [
                    'name' => 'Иванов Иван',
                    'person' =>
                        [
                            'last_name' => 'Иванов',
                            'first_name' => 'Иван',
                            'patronymic_name' => 'Иванович',
                            'birth_date' => '1986-06-15',
                            'gender' => 'male',
                            'phone' => '+7-999-999-99-99',
                            'email' => 'some@email.com',
                            'picture' => null,
                            'picture_thumb' => null,
                            'instagram_username' => 'instaperez',
                            'telegram_username' => 'teleperez',
                            'vk_uid' => null,
                            'vk_url' => 'https://vk.com/durov',
                            'facebook_uid' => null,
                            'facebook_url' => 'https://facebook.com/mark',
                            'note' => 'Some testy note',
                        ],
                ]
            ]);
    }

    /**
     * @param array $data
     * @dataProvider provideInvalidStoreData
     */
    public function testInvalidStore(array $data): void
    {
        $this
            ->post(self::URL, $data)
            ->assertStatus(422);
    }

    /**
     * @return array
     */
    public function provideInvalidStoreData(): array
    {
        return [
            [
                [
                    'last_name' => 'Иванов',
                    'first_name' => 'Иван',
                    'patronymic_name' => 'Иванович',
                    'phone' => '8-999-999-99-99'
                ],
            ],
            [
                [
                    'first_name' => 'Иван',
                    'patronymic_name' => 'Иванович',
                    'birth_date' => '1986-01-08',
                    'phone' => '8-999-999-99-99'
                ],
            ],
            [
                [
                    'last_name' => 'Иванов',
                    'first_name' => 'Иван',
                    'birth_date' => '1986-01-08',
                    'phone' => '8-999-999-99-99'
                ],
            ],
            [
                [
                    'last_name' => 'Иванов',
                    'first_name' => 'Иван',
                    'patronymic_name' => 'Иванович',
                    'birth_date' => '1986-01-08'
                ],
            ],
        ];
    }


    public function testCreateFromPerson(): void
    {
        $person = $this->createFakePerson();
        $data = [
            'person_id' => $person->id,
        ];
        $url = self::URL . '/from_person';

        $this
            ->post($url, $data)
            ->assertStatus(201)
            ->assertJsonStructure(self::JSON_STRUCTURE)
            ->assertJson([
                'data' => [
                    'person' => [
                        'id' => $person->id,
                        'last_name' => $person->last_name,
                        'first_name' => $person->first_name,
                        'patronymic_name' => $person->patronymic_name,
                        'birth_date' => $person->birth_date ? $person->birth_date->toDateString() : null,
                        'gender' => $person->gender,
                        'phone' => $person->phone,
                        'email' => $person->email,
                        'picture' => $person->picture,
                        'picture_thumb' => $person->picture_thumb,
                        'instagram_username' => $person->instagram_username,
                        'telegram_username' => $person->telegram_username,
                        'vk_uid' => $person->vk_uid,
                        'vk_url' => $person->vk_url,
                        'facebook_uid' => $person->facebook_uid,
                        'facebook_url' => $person->facebook_url,
                        'note' => $person->note,
                        'created_at' => $person->created_at->toDateTimeString()
                    ]
                ]
            ]);
    }

    public function testDestroy(): void
    {
        $customer = $this->createFakeCustomer();
        $person = $customer->person;

        $url = self::URL . '/' . $customer->id;

        $this
            ->delete($url)
            ->assertOk();

        $this->assertDatabaseHas(\App\Models\Person::TABLE, ['id' => $person->id]);
        $this->assertDatabaseMissing(\App\Models\Customer::TABLE, ['id' => $customer->id]);
        $this->assertDatabaseMissing(\App\Models\Contract::TABLE, ['customer_id' => $customer->id]);
    }
}
