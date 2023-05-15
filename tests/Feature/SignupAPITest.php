<?php

namespace Tests\Feature;

use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SignupAPITest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    /**
     * sign up valid inputs test
     *
     */
    public function test_valid_inputs_validation()
    {
        $faker = Faker::create();
        $password = $faker->password;

        $inputs = [
            "name" => $faker->name,
            "email" => $faker->safeEmail,
            "password" => $password,
            "password_confirmation" => $password,
        ];

        $response = $this->postJson(route('users.signup'),
            $inputs
        );
        $response->assertStatus(200);
        $response->assertJsonStructure(['token']);
        $token = $response->json('token');
        $this->assertIsString($token);

        // DB assertion
        $this->assertDatabaseHas('users', ['name' => $inputs['name'], 'email' => $inputs['email']]);
        $this->assertDatabaseMissing('users', ['email' => 'notexistingemail@ss.com']);

        // unique email check
        $response = $this->postJson(route('users.signup'),
            $inputs
        );
        $response->assertStatus(422);
    }

    /**
     * @dataProvider signup_data_that_should_fail
     */
    public function test_signup_data_that_should_fail(array $requestData)
    {
        $response = $this->postJson(route('users.signup'),
            $requestData
        );
        $response->assertStatus(422);
    }

    /**
     * sign up data test cases 
     *
     * @return array
     */
    public function signup_data_that_should_fail(): array
    {
        $name = 'Albert Sebastiar';
        $email = 'albertrajmca@gmail.com';
        $password = 'abc#ci124JK';
        $confirmPassword = 'abc#ci124JK';

        return [
            'no_input_data' => [
                [],
            ],
            'no_name_input' => [
                [
                    'email' => $email,
                    'password' => $password,
                    'password_confirmation' => $confirmPassword,
                ],
            ],
            'no_email_input' => [
                [
                    'name' => $name,
                    'password' => $password,
                    'password_confirmation' => $confirmPassword,
                ],
            ],
            'no_password_input' => [
                [
                    'name' => $name,
                    'email' => $email,
                    'password_confirmation' => $confirmPassword,
                ],
            ],
            'no_password_confirmation_input' => [
                [
                    'name' => $name,
                    'email' => $email,
                    'password' => $confirmPassword,
                ],
            ],
            'non_string_name_input' => [
                [
                    'name' => 999,
                    'email' => $email,
                    'password' => $password,
                    'password_confirmation' => $confirmPassword,
                ],
            ],
            'invalid_email_input' => [
                [
                    'name' => $name,
                    'email' => 'albert',
                    'password' => $password,
                    'password_confirmation' => $confirmPassword,
                ],
            ],
            'min_password_length' => [
                [
                    'name' => $name,
                    'email' => 'alb',
                    'password' => $password,
                    'password_confirmation' => $confirmPassword,
                ],
            ],
            'max_password_length' => [
                [
                    'name' => $name,
                    'email' => $email,
                    'password' => 'abcdefghijklmnopqrstuvwxyz',
                    'password_confirmation' => $confirmPassword,
                ],
            ],
            'password_mis_match_length' => [
                [
                    'name' => $name,
                    'email' => $email,
                    'password' => 'mismatch',
                    'password_confirmation' => $confirmPassword,
                ],
            ],
        ];
    }
}
