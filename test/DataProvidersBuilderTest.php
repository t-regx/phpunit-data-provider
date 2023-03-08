<?php

declare(strict_types=1);

namespace TRegx\DataProvider\Test;

use PHPUnit\Framework\TestCase;
use TRegx\DataProvider\DataProvidersBuilder;

/**
 * @covers \TRegx\DataProvider\DataProvidersBuilder
 */
class DataProvidersBuilderTest extends TestCase
{
    /**
     * @test
     */
    public function test(): void
    {
        // given
        $builder = new DataProvidersBuilder([], null, '\json_encode');

        // when
        $result = $builder
            ->addSection('login', 'logout', 'recover')
            ->addSection('as-user', 'as-admin')
            ->build();

        // then
        $this->assertThat(iterator_to_array($result), $this->equalTo([
            '[0,0]' => ['login', 'as-user'],
            '[0,1]' => ['login', 'as-admin'],
            '[1,0]' => ['logout', 'as-user'],
            '[1,1]' => ['logout', 'as-admin'],
            '[2,0]' => ['recover', 'as-user'],
            '[2,1]' => ['recover', 'as-admin'],
        ]));
    }

    /**
     * @test
     */
    public function joinedIteration(): void
    {
        // when
        $result = $this->provideJoinedIterations()->build();

        // then
        $this->assertThat(iterator_to_array($result), $this->equalTo([
            '[0,0]' => ['ssh', 'user@page.com', 22, '/sign-up', 'login'],
            '[0,1]' => ['ssh', 'user@page.com', 22, '/sign-out', 'logout'],
            '[0,2]' => ['ssh', 'user@page.com', 22, '/restore-password', 'recover'],

            '[1,0]' => ['https', 'https://page.com', 443, '/sign-up', 'login'],
            '[1,1]' => ['https', 'https://page.com', 443, '/sign-out', 'logout'],
            '[1,2]' => ['https', 'https://page.com', 443, '/restore-password', 'recover'],
        ]));
    }

    /**
     * @test
     */
    public function shouldMap(): void
    {
        // when
        $result = $this->provideJoinedIterations()
            ->entryMapper(function (array $keys) {
                return array_map('strtoupper', $keys);
            })
            ->build();

        // then
        $this->assertThat(iterator_to_array($result), $this->equalTo([
            '[0,0]' => ['SSH', 'USER@PAGE.COM', '22', '/SIGN-UP', 'LOGIN'],
            '[0,1]' => ['SSH', 'USER@PAGE.COM', '22', '/SIGN-OUT', 'LOGOUT'],
            '[0,2]' => ['SSH', 'USER@PAGE.COM', '22', '/RESTORE-PASSWORD', 'RECOVER'],

            '[1,0]' => ['HTTPS', 'HTTPS://PAGE.COM', '443', '/SIGN-UP', 'LOGIN'],
            '[1,1]' => ['HTTPS', 'HTTPS://PAGE.COM', '443', '/SIGN-OUT', 'LOGOUT'],
            '[1,2]' => ['HTTPS', 'HTTPS://PAGE.COM', '443', '/RESTORE-PASSWORD', 'RECOVER'],
        ]));
    }

    /**
     * @test
     */
    public function shouldMapKeys(): void
    {
        // when
        $result = $this->provideJoinedIterations()
            ->entryKeyMapper(function (array $keys) {
                return join('+', $keys);
            })
            ->build();

        // then
        $this->assertThat(iterator_to_array($result), $this->equalTo([
            '0+0' => ['ssh', 'user@page.com', '22', '/sign-up', 'login'],
            '0+1' => ['ssh', 'user@page.com', '22', '/sign-out', 'logout'],
            '0+2' => ['ssh', 'user@page.com', '22', '/restore-password', 'recover'],

            '1+0' => ['https', 'https://page.com', '443', '/sign-up', 'login'],
            '1+1' => ['https', 'https://page.com', '443', '/sign-out', 'logout'],
            '1+2' => ['https', 'https://page.com', '443', '/restore-password', 'recover'],
        ]));
    }

    /**
     * @test
     */
    public function shouldFlatMap(): void
    {
        // when
        $result = $this->provideJoinedIterations()
            ->entryMapper(function (array $keys) {
                return sprintf('%s://%s:%d%s', ...$keys);
            })
            ->build();

        // then
        $this->assertThat(iterator_to_array($result), $this->equalTo([
            '[0,0]' => ['ssh://user@page.com:22/sign-up'],
            '[0,1]' => ['ssh://user@page.com:22/sign-out'],
            '[0,2]' => ['ssh://user@page.com:22/restore-password'],

            '[1,0]' => ['https://https://page.com:443/sign-up'],
            '[1,1]' => ['https://https://page.com:443/sign-out'],
            '[1,2]' => ['https://https://page.com:443/restore-password'],
        ]));
    }

    /**
     * @return DataProvidersBuilder
     */
    private function provideJoinedIterations(): DataProvidersBuilder
    {
        return (new DataProvidersBuilder([], null, '\json_encode'))
            ->addJoinedSection(['ssh', 'user@page.com', 22], ['https', 'https://page.com', 443])
            ->addJoinedSection(['/sign-up', 'login'], ['/sign-out', 'logout'], ['/restore-password', 'recover']);
    }

    /**
     * @test
     */
    public function singleIteration(): void
    {
        // given
        $builder = new DataProvidersBuilder([], null, '\json_encode');

        // when
        $result = $builder
            ->addSection('one', 'two', 'three')
            ->build();

        // then
        $this->assertThat(iterator_to_array($result), $this->equalTo([
            '[0]' => ['one'],
            '[1]' => ['two'],
            '[2]' => ['three'],
        ]));
    }
}
