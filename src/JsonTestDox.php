<?php

namespace Beblife;

class JsonTestDox
{
    public function results()
    {
        return [
            "tests" => [],
            "meta" => [
                "total" => 0,
            ],
        ];
    }

    public function print()
    {
        return json_encode($this->results());
    }
}
