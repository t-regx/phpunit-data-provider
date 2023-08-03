<?php
namespace Test\Fixture;

trait Resources
{
    public function resource()
    {
        $resources = \get_resources();
        return \reset($resources);
    }
}

