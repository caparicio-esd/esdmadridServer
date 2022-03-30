<?php

namespace ESD_BE\Api;

define("BASE_API_PATH", "esd/v1");

abstract class AbstractEndpoint
{
  protected $route;
  protected $config;
  protected $callback;

  public function __construct(string $route, array $config, callable $callback)
  {
    $this->$route = $route;
    $this->$config = $config;
    $this->$callback = $callback;

    add_action(
      "rest_api_init",
      [
        &$this,
        function () {
          global $route, $config;
          register_rest_route(BASE_API_PATH, $route, [
              "methods" => "GET"
          ]);
        },
      ],
      10
    );
  }
}
