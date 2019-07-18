<?php
/**
 * File: StudentTest.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-18
 * Copyright (c) 2019
 */
declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Traits\CreatesFakePerson;
use Tests\Traits\CreatesFakeStudent;

/**
 * Class PersonTest
 */
class StudentTest extends \Tests\TestCase
{
    use WithFaker, RefreshDatabase, CreatesFakePerson, CreatesFakeStudent;

    protected const URL = '/api/students';

    protected const JSON_STRUCTURE = [
        'data' => [
            'id',
            'name',
            'person',
            'customer',
            'card_number',
            'status',
            'status_label',
            'seen_at',
            'created_at'
        ]
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->refreshDatabase();
    }

    public function testShow(): void
    {
        $student = $this->createFakeStudent(['status' => \App\Models\Student::STATUS_POTENTIAL]);
        $person = $student->person;

        $url = self::URL . '/' . $student->id;

        $this
            ->get($url)
            ->assertOk()
            ->assertJson([
                'data' => [
                    'id' => $student->id,
                    'name' => $student->name,
                    'person' => [
                        'id' => $person->id,
                        'last_name' => $person->last_name,
                        'first_name' => $person->first_name,
                        'patronymic_name' => $person->patronymic_name,
                        'birth_date' => $person->birth_date ?? $person->birth_date->toDateString(),
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
                    'status' => $student->status,
                    'status_label' => \trans($student->status),
                    'seen_at' => $student->seen_at->toDateTimeString(),
                    'created_at' => $student->created_at->toDateTimeString()
                ]
            ]);
    }

    public function testStore(): void
    {
        $data = [
            'card_number' => 9999,
            'last_name' => 'Иванов',
            'first_name' => 'Иван',
            'patronymic_name' => 'Иванович',
            'birth_date' => '1986-06-15',
            'gender' => 'male',
            'phone' => '+7-999-999-99-99',
            'email' => 'some@email.com',
            'picture' => 'https://picsum.photos/id/400/600/300',
            'picture_thumb' => 'https://picsum.photos/id/400/200/200',
            'instagram_username' => 'instaperez',
            'telegram_username' => 'teleperez',
            'vk_uid' => '1326540',
            'vk_url' => 'https://vk.com/durov',
            'facebook_uid' => '654123',
            'facebook_url' => 'https://facebook.com/mark',
            'note' => 'Some testy note',
        ];

        $this
            ->post(self::URL, $data)
            ->assertStatus(201)
            ->assertJsonStructure(self::JSON_STRUCTURE)
            ->assertJson([
                'data' => [
                    'card_number' => 9999,
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
                            'picture' => 'https://picsum.photos/id/400/600/300',
                            'picture_thumb' => 'https://picsum.photos/id/400/200/200',
                            'instagram_username' => 'instaperez',
                            'telegram_username' => 'teleperez',
                            'vk_uid' => '1326540',
                            'vk_url' => 'https://vk.com/durov',
                            'facebook_uid' => '654123',
                            'facebook_url' => 'https://facebook.com/mark',
                            'note' => 'Some testy note',
                        ],
                    'status' => 'potential',
                    'status_label' => 'potential'
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
                    'patronymic_name' => 'Иванович',
                    'birth_date' => '1986-06-15',
                ],
            ],
            [
                [
                    'first_name' => 'Иван',
                    'vk_url' => 'some text',
                ],
            ],
            [
                [
                    'first_name' => 'Иван',
                    'facebook_url' => 'no url',
                ],
            ],
            [
                [
                    'first_name' => 'Иван',
                    'email' => 'not an email',
                ]
            ],
            [
                [
                    'card_number' => 'Иван',
                ]
            ],
        ];
    }

    public function testUpdate(): void
    {
        $data = ['card_number' => 1234];

        $student = $this->createFakeStudent(['card_number' => 9999]);
        $person = $student->person;

        $url = self::URL . '/' . $student->id;

        $this
            ->patch($url, $data)
            ->assertStatus(200)
            ->assertJsonStructure(self::JSON_STRUCTURE)
            ->assertJson([
                'data' => [
                    'card_number' => 1234,
                    'id' => $student->id,
                    'name' => $student->name,
                    'person' => [
                        'id' => $person->id,
                        'last_name' => $person->last_name,
                        'first_name' => $person->first_name,
                        'patronymic_name' => $person->patronymic_name,
                        'birth_date' => $person->birth_date ?? $person->birth_date->toDateString(),
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
                    'status' => $student->status,
                    'status_label' => \trans($student->status),
                    'seen_at' => $student->seen_at->toDateTimeString(),
                    'created_at' => $student->created_at->toDateTimeString()
                ]
            ]);
    }

    /**
     * @param array $data
     * @dataProvider provideInvalidUpdateData
     */
    public function testInvalidUpdate(array $data): void
    {
        $student = $this->createFakeStudent();

        $url = self::URL . '/' . $student->id;

        $this
            ->patch($url, $data)
            ->assertStatus(422);
    }

    /**
     * @return array
     */
    public function provideInvalidUpdateData(): array
    {
        return [
            [
                [
                    'card_number' => 'Иван',
                ]
            ],
        ];
    }

    public function testDestroy(): void
    {
        $student = $this->createFakeStudent();
        $person = $student->person;

        $url = self::URL . '/' . $student->id;

        $this
            ->delete($url)
            ->assertOk();

        $this->assertDatabaseMissing(\App\Models\Person::TABLE, ['id' => $person->id]);
        $this->assertDatabaseMissing(\App\Models\Student::TABLE, ['id' => $student->id]);
    }
}
