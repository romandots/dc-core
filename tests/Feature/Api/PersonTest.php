<?php
/**
 * File: PersonTest.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-18
 * Copyright (c) 2019
 */
declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Traits\CreatesFakePerson;

/**
 * Class PersonTest
 */
class PersonTest extends \Tests\TestCase
{
    use WithFaker, RefreshDatabase, CreatesFakePerson;

    protected const URL = '/api/people';
    protected const JSON_STRUCTURE = [
        'data' => [
            'id',
            'last_name',
            'first_name',
            'patronymic_name',
            'birth_date',
            'gender',
            'phone',
            'email',
            'picture',
            'picture_thumb',
            'instagram_username',
            'telegram_username',
            'vk_uid',
            'vk_url',
            'facebook_uid',
            'facebook_url',
            'note',
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
        $person = $this->createFakePerson();

        $url = self::URL . '/' . $person->id;

        $this
            ->get($url)
            ->assertOk()
            ->assertJson([
                'data' => [
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
            'phone' => '8(999)999 99-99',
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
                ]
            ]);
    }

    /**
     * @param array $data
     * @dataProvider provideInvalidData
     */
    public function testInvalidStore(array $data): void
    {
        $this
            ->post(self::URL, $data)
            ->assertStatus(422);
    }

    public function testUpdate(): void
    {
        $data = [
            'last_name' => 'Иванов',
            'first_name' => 'Иван',
            'patronymic_name' => 'Иванович',
            'birth_date' => '1986-06-15',
            'gender' => 'male',
            'phone' => '8(999)999 99-99',
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

        $person = $this->createFakePerson();

        $url = self::URL . '/' . $person->id;

        $this
            ->patch($url, $data)
            ->assertStatus(200)
            ->assertJsonStructure(self::JSON_STRUCTURE)
            ->assertJson([
                'data' => [
                    'id' => $person->id,
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
                    'created_at' => $person->created_at->toDateTimeString()
                ]
            ]);
    }

    /**
     * @param array $data
     * @dataProvider provideInvalidData
     */
    public function testInvalidUpdate(array $data): void
    {
        $person = $this->createFakePerson();

        $url = self::URL . '/' . $person->id;

        $this
            ->patch($url, $data)
            ->assertStatus(422);
    }

    /**
     * @return array
     */
    public function provideInvalidData(): array
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
        ];
    }

    public function testDestroy(): void
    {
        $person = $this->createFakePerson();

        $url = self::URL . '/' . $person->id;

        $this
            ->delete($url)
            ->assertOk();

        $this->assertDatabaseMissing(\App\Models\Person::TABLE, ['id' => $person->id]);
    }
}
