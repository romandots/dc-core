<?php
/**
 * File: UserTest.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-20
 * Copyright (c) 2019
 */
declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Traits\CreatesFakePerson;
use Tests\Traits\CreatesFakeUser;

/**
 * Class UserTest
 */
class UserTest extends \Tests\TestCase
{
    use WithFaker, RefreshDatabase, CreatesFakePerson, CreatesFakeUser;

    protected const URL = '/api/users';

    protected const JSON_STRUCTURE = [
        'data' => [
            'id',
            'name',
            'person',
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
        $user = $this->createFakeUser();
        $person = $user->person;

        $url = self::URL . '/' . $user->id;

        $this
            ->get($url)
            ->assertOk()
            ->assertJson([
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
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
                    'seen_at' => $user->seen_at->toDateTimeString(),
                    'created_at' => $user->created_at->toDateTimeString()
                ]
            ]);
    }

    public function testStore(): void
    {
        $data = [
            'username' => 'username',
            'password' => 'password',
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
                    'password' => 'password',
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
                ],
            ],
            [
                [
                    'username' => 'username',
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
                ],
            ],
            [
                [
                    'username' => 'username',
                    'password' => 'password',
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
                ],
            ],
            [
                [
                    'username' => 'username',
                    'password' => 'password',
                    'last_name' => 'Иванов',
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
                ],
            ],
            [
                [
                    'username' => 'username',
                    'password' => 'password',
                    'last_name' => 'Иванов',
                    'first_name' => 'Иван',
                    'birth_date' => '1986-06-15',
                    'gender' => 'male',
                    'phone' => '+7-999-999-99-99',
                    'email' => 'some@email.com',
                    'instagram_username' => 'instaperez',
                    'telegram_username' => 'teleperez',
                    'vk_url' => 'https://vk.com/durov',
                    'facebook_url' => 'https://facebook.com/mark',
                    'note' => 'Some testy note',
                ],
            ],
            [
                [
                    'username' => 'username',
                    'password' => 'password',
                    'last_name' => 'Иванов',
                    'first_name' => 'Иван',
                    'patronymic_name' => 'Иванович',
                    'gender' => 'male',
                    'phone' => '+7-999-999-99-99',
                    'email' => 'some@email.com',
                    'instagram_username' => 'instaperez',
                    'telegram_username' => 'teleperez',
                    'vk_url' => 'https://vk.com/durov',
                    'facebook_url' => 'https://facebook.com/mark',
                    'note' => 'Some testy note',
                ],
            ],
            [
                [
                    'username' => 'username',
                    'password' => 'password',
                    'last_name' => 'Иванов',
                    'first_name' => 'Иван',
                    'patronymic_name' => 'Иванович',
                    'birth_date' => '1986-06-15',
                    'gender' => 'male',
                    'email' => 'some@email.com',
                    'instagram_username' => 'instaperez',
                    'telegram_username' => 'teleperez',
                    'vk_url' => 'https://vk.com/durov',
                    'facebook_url' => 'https://facebook.com/mark',
                    'note' => 'Some testy note',
                ],
            ],
        ];
    }

    public function testCreateFromPerson(): void
    {
        $person = $this->createFakePerson();
        $data = [
            'person_id' => $person->id,
            'username' => 'username',
            'password' => '123456'
        ];
        $url = self::URL . '/from_person';

        $this
            ->post($url, $data)
            ->assertStatus(201)
            ->assertJsonStructure(self::JSON_STRUCTURE)
            ->assertJson([
                'data' => [
                    'username' => 'username',
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

    public function testUpdatePassword(): void
    {
        $oldPassword = '123456';
        $newPassword = '654321';

        $user = $this->createFakeUser(['password' => \Hash::make($oldPassword)]);

        $data = [
            'old_password' => $oldPassword,
            'new_password' => $newPassword,
        ];

        $url = self::URL . '/' . $user->id . '/password';

        $this
            ->patch($url, $data)
            ->assertOk();

        $user->refresh();

        $this->assertTrue(\Hash::check($newPassword, $user->password));
    }

    /**
     * @param array $data
     * @dataProvider provideInvalidPasswords
     */
    public function testInvalidUpdatePassword(array $data): void
    {
        $user = $this->createFakeUser(['password' => \Hash::make('123456')]);

        $url = self::URL . '/' . $user->id . '/password';

        $this
            ->patch($url, $data)
            ->assertStatus(422);

        $user->refresh();

        $this->assertFalse(\Hash::check('654321', $user->password));
    }

    /**
     * @return array
     */
    public function provideInvalidPasswords(): array
    {
        return [
            [
                [
                    'old_password' => '654321',
                    'new_password' => '654321',
                ]
            ],
            [
                [
                    'old_password' => '123456',
                ]
            ]
        ];
    }

    public function testUpdate(): void
    {
        $user = $this->createFakeUser();

        $data = [
            'username' => 'username',
            'name' => 'Another Name',
        ];

        $url = self::URL . '/' . $user->id;
        $person = $user->person;

        $this
            ->patch($url, $data)
            ->assertOk()
            ->assertJsonStructure(self::JSON_STRUCTURE)
            ->assertJson([
                'data' => [
                    'username' => 'username',
                    'name' => 'Another Name',
                    'person' =>
                        [
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
                ]
            ]);
    }

    /**
     * @param array $data
     * @dataProvider provideInvalidUpdateData
     */
    public function testInvalidUpdate(array $data): void
    {
        $this->createFakeUser(['username' => 'existingUser']);
        $user = $this->createFakeUser();
        $url = self::URL . '/' . $user->id;

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
                    'username' => 'existingUser',
                    'name' => 'Another Name',
                ]
            ],
            [
                [
                    'username' => 'a',
                    'name' => 'Another Name',
                ]
            ],
            [
                [
                    'username' => 'username',
                    'name' => 'a',
                ]
            ],
        ];
    }

    public function testDestroy(): void
    {
        $user = $this->createFakeUser();
        $person = $user->person;

        $url = self::URL . '/' . $user->id;

        $this
            ->delete($url)
            ->assertOk();

        $this->assertDatabaseHas(\App\Models\Person::TABLE, ['id' => $person->id]);
        $this->assertDatabaseMissing(\App\Models\User::TABLE, ['id' => $user->id]);
    }
}
