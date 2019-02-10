<?php

namespace Fooscore\Tests\Unit;

use Fooscore\Identity\Credentials;
use Fooscore\Identity\Identity;
use Fooscore\Identity\RegisteredUsers;
use Mockery;
use PHPUnit\Framework\TestCase;

/**
 * @group unit
 *
 * In order to score goals of my team mates
 * As a referee
 * I want to log in
 */
class LogInTest extends TestCase
{
    public function testShouldLogInAsARegisteredUser(): void
    {
        // Given
        $john = [
            'username' => 'john@example.com',
            'password' => '123',
            'name' => 'John Doe',
            'token' => 'abc',
        ];

        /** @var RegisteredUsers $registeredUsers */
        $registeredUsers = Mockery::mock(RegisteredUsers::class, [
            'getUser' => $john,
        ]);

        // When
        $identity = new Identity($registeredUsers);
        $token = $identity->logIn(new Credentials($john['username'], $john['password']));

        // Then
        self::assertSame($john['token'], $token);
    }

    public function testShouldNotLogInIfNotRegistered(): void
    {
        // Given
        /** @var RegisteredUsers $registeredUsers */
        $registeredUsers = Mockery::mock(RegisteredUsers::class, [
            'getUser' => null,
        ]);

        // When
        $identity = new Identity($registeredUsers);
        $token = $identity->logIn(new Credentials('john@example.com', 'foo'));

        // Then
        self::assertSame(null, $token);
    }
}
