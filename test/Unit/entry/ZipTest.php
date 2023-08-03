<?php
namespace Test\Unit\entry;

use PHPUnit\Framework\TestCase;
use Test\Fixture\Assertion\AssertsIteration;
use TRegx\PhpUnit\DataProviders\DataProvider;

class ZipTest extends TestCase
{
    use AssertsIteration;

    /**
     * @test
     */
    public function shouldZipIdentity()
    {
        $zip = DataProvider::zip([
            ['Eddard', 'Ice'],
            ['Jon', 'Longclaw'],
        ]);
        $this->assertIteratesValues($zip, [
            ['Eddard', 'Ice'],
            ['Jon', 'Longclaw'],
        ]);
    }

    /**
     * @test
     */
    public function shouldZip()
    {
        $zip = DataProvider::zip([
            'ned'     => ['Eddard', 'Stark'],
            'jon'     => ['Jon', 'Snow'],
            'arya'    => ['Arya', 'Stark'],
            'joffrey' => ['Joffrey', 'Baratheon'],
            'brienne' => ['Brienne', 'Tarth'],
            'randyll' => ['Randyll', 'Tarly'],
        ], [
            'ice'    => ['Ice', 'melted'],
            'claw'   => ['Longclaw', 'given'],
            'needle' => ['Needle', 'gifted'],
            'wail'   => ["Widow's Wail", 'left'],
            'oath'   => ['Oathkeeper', 'intended'],
            'bane'   => ['Heartsbane', 'stolen'],
        ]);
        $this->assertIteratesValues($zip, [
            ['Eddard', 'Stark', 'Ice', 'melted'],
            ['Jon', 'Snow', 'Longclaw', 'given'],
            ['Arya', 'Stark', 'Needle', 'gifted'],
            ['Joffrey', 'Baratheon', "Widow's Wail", 'left'],
            ['Brienne', 'Tarth', 'Oathkeeper', 'intended'],
            ['Randyll', 'Tarly', 'Heartsbane', 'stolen'],
        ]);
    }
}
