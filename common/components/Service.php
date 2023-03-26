<?php

namespace common\components;

use GuzzleHttp\Client;
use yii\base\Component;

/**
 * Class Service
 *
 * @package common\components
 *
 * @property Client $client
 */
class Service extends Component
{
    const OPTION_TIMEOUT = 5.0;

    public $host;
    public $headers = [];

    /** @var Client */
    private $_client;

    public function init()
    {
        $this->_client = new Client([
            'base_uri' => $this->host,
            'timeout'  => self::OPTION_TIMEOUT,
            'headers'  => $this->headers,
        ]);
    }

    public function getClient()
    {
        return $this->_client;
    }
}
