<?php
/**
 * File: InstructorTest.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-19
 * Copyright (c) 2019
 */
declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Traits\CreatesFakeInstructor;
use Tests\Traits\CreatesFakePerson;

/**
 * Class PersonTest
 */
class InstructorTest extends \Tests\TestCase
{
    use WithFaker, RefreshDatabase, CreatesFakePerson, CreatesFakeInstructor;

    protected const URL = '/api/instructors';

    protected const JSON_STRUCTURE = [
        'data' => [
            'id',
            'name',
            'person',
            'description',
            'picture',
            'display',
            'status',
            'status_label',
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
        $instructor = $this->createFakeInstructor(['status' => \App\Models\Instructor::STATUS_HIRED]);
        $person = $instructor->person;

        $url = self::URL . '/' . $instructor->id;

        $this
            ->get($url)
            ->assertOk()
            ->assertJson([
                'data' => [
                    'id' => $instructor->id,
                    'name' => $instructor->name,
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
                    'status' => $instructor->status,
                    'status_label' => \trans($instructor->status),
                    'seen_at' => $instructor->seen_at->toDateTimeString(),
                    'created_at' => $instructor->created_at->toDateTimeString()
                ]
            ]);
    }

    public function testStore(): void
    {
        $data = [
            'status' => \App\Models\Instructor::STATUS_HIRED,
            'description' => 'Some teacher info',
            'display' => true,
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
                    'status' => \App\Models\Instructor::STATUS_HIRED,
                    'status_label' => \trans(\App\Models\Instructor::STATUS_HIRED),
                    'description' => 'Some teacher info',
                    'display' => true,
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
                    'status' => 'impossible',
                    'display' => true
                ],
            ],
            [
                [
                    'description' => 'Описание',
                    'display' => true
                ],
            ],
            [
                [
                    'status' => 'hired',
                    'display' => 'true'
                ],
            ],
        ];
    }


    public function testCreateFromPerson(): void
    {
        $person = $this->createFakePerson();
        $data = [
            'status' => \App\Models\Instructor::STATUS_HIRED,
            'description' => 'Some teacher info',
            'display' => true,
            'person_id' => $person->id,
        ];
        $url = self::URL . '/from_person';

        $this
            ->post($url, $data)
            ->assertStatus(201)
            ->assertJsonStructure(self::JSON_STRUCTURE)
            ->assertJson([
                'data' => [
                    'name' => "{$person->last_name} {$person->first_name}",
                    'status' => \App\Models\Instructor::STATUS_HIRED,
                    'description' => 'Some teacher info',
                    'display' => true,
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

    public function testUpdate(): void
    {
        $data = [
            'status' => \App\Models\Instructor::STATUS_FIRED,
            'description' => 'Some other info',
            'display' => false,
        ];

        $instructor = $this->createFakeInstructor([
            'status' => \App\Models\Instructor::STATUS_HIRED,
            'description' => 'Some teacher info',
            'display' => true,
        ]);
        $person = $instructor->person;

        $url = self::URL . '/' . $instructor->id;

        $this
            ->patch($url, $data)
            ->assertStatus(200)
            ->assertJsonStructure(self::JSON_STRUCTURE)
            ->assertJson([
                'data' => [
                    'id' => $instructor->id,
                    'name' => $instructor->name,
                    'status' => \App\Models\Instructor::STATUS_FIRED,
                    'status_label' => \trans(\App\Models\Instructor::STATUS_FIRED),
                    'description' => 'Some other info',
                    'display' => false,
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
                    'seen_at' => $instructor->seen_at->toDateTimeString(),
                    'created_at' => $instructor->created_at->toDateTimeString()
                ]
            ]);
    }

    /**
     * @param array $data
     * @dataProvider provideInvalidUpdateData
     */
    public function testInvalidUpdate(array $data): void
    {
        $instructor = $this->createFakeInstructor();

        $url = self::URL . '/' . $instructor->id;

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
                    'status' => 'impossible',
                    'display' => true
                ],
            ],
            [
                [
                    'description' => 'Описание',
                    'display' => true
                ],
            ],
            [
                [
                    'status' => 'hired',
                    'display' => 'true'
                ],
            ],
        ];
    }

    public function testDestroy(): void
    {
        $instructor = $this->createFakeInstructor();
        $person = $instructor->person;

        $url = self::URL . '/' . $instructor->id;

        $this
            ->delete($url)
            ->assertOk();

        $this->assertDatabaseHas(\App\Models\Person::TABLE, ['id' => $person->id]);
        $this->assertDatabaseMissing(\App\Models\Instructor::TABLE, ['id' => $instructor->id]);
    }
}
