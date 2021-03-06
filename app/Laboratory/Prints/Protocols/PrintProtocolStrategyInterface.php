<?php

namespace App\Laboratory\Prints\Protocols;

interface PrintProtocolStrategyInterface
{
    /**
     * Print a protocol allowing filtering by practices
     *
     * @param $protocol_id
     * @param array $filter_practices
     * @return \Illuminate\Http\Response
     */
    public function printProtocol($protocol_id, $filter_practices = []);
}
