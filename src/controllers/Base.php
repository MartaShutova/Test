<?php
namespace Controllers;

use \Slim\Container;

class Base
{

    /**
     * @var \Slim\Container
     */
    protected $container;

    /**
     * @param object $container
     * @return void
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }
    
    /**
     * @param string $key
     * @return string|null
     */
    public function httpGet($key)
    {
        if (isset($this->container->request->getQueryParams()[$key])) {
            return $this->container->request->getQueryParams()[$key];
        }
		
        return null;
    }

    /**
     * @param string $key
     * @return string|null
     */
    public function httpPost($key)
    {
        if (isset($this->container->request->getParsedBody()[$key])) {
            return $this->container->request->getParsedBody()[$key];
        }
		
        return null;
    }
    
    /**
     * @param object $data
     * @return string
     * @throws \Exception
     */
    public static function encode($data)
    {
        if (!is_object($data)) {
            throw new \Exception('$data deve ser um objeto.');
        }
		
        return json_encode($data, JSON_PRETTY_PRINT) . PHP_EOL;
    }
    
    /**
     * @param string $code
     * @param string $path
     * @param string $status
     * @param string $extra
     * @return string
     */
    public static function error($code, $path, $status, $extra = '')
    {
        $error = new \StdClass;
        
        $error->error = [
            'code' => $code,
            'path' => $path,
            'status' => $status
        ];
        
        if ($extra) {
            $error->error['extra'] = $extra;
        }

        return self::encode($error);
    }
    
    /**
     * @param string $request
     * @param string $path
     * @return string
     */
    public function resource($path)
    {
        $uri = $this->container->request->getUri();

        $scheme = $uri->getScheme();
        $host = $uri->getHost();
        $port = $uri->getPort();
        
        $location = $scheme . '://' . $host . ($port ? ':' . $port : null) . '/' . $path;
        
        $resource = new \StdClass;
        
        $resource->resource = [
            'location' => $location
        ];

        return self::encode($resource);
    }
    
    /**
     * @param array $validations
     * @return bool
     * @throws \Exception
     */
    public static function validate($validations)
    {
        if (!is_array($validations)) {
            throw new \Exception('$validations');
        }
		
		foreach ($validations as $v) {
			if ($v === false) {
				return false;
			}
		}
        
        return true;
    }
}
