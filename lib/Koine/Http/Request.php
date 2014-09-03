<?php

namespace Koine\Http;

use Koine\Hash;
use Koine\Object;
use InvalidArgumentException;

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Request extends Object
{

    /**
     * Request methods
     */
    const METHOD_GET    = 'GET';
    const METHOD_POST   = 'POST';
    const METHOD_PUT    = 'PUT';
    const METHOD_PATCH  = 'PATCH';
    const METHOD_DELETE = 'DELETE';

    /**
     * The accepted request methods
     * @var array
     */
    protected $acceptedMethods = array(
        self::METHOD_GET,
        self::METHOD_POST,
        self::METHOD_PATCH,
        self::METHOD_DELETE,
        self::METHOD_PUT,
    );

    /**
     * @var Environment
     */
    protected $environment;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var Cookies
     */
    protected $cookies;

    /**
     * @var Params
     */
    protected $params;

    /**
     * @var Params
     */
    protected $postParams;

    /**
     * @var Params
     */
    protected $getParams;

    /**
     * Valid options:
     *      environment - The Environment
     *      session - The Session
     *      cookies - The Cookies
     *
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        $options = new Hash($options);

        $fetchCallback = function ($key) {
            throw new InvalidArgumentException(
                "Parameter '$key' was not provided"
            );
        };

        $options->fetch('environment', $fetchCallback);
        $options->fetch('session', $fetchCallback);
        $options->fetch('params', $fetchCallback);
        $options->fetch('cookies', $fetchCallback);

        foreach ($options as $option => $value) {
            $this->send('set' . ucfirst($option), $value);
        }
    }

    /**
     * @param  Environment $environment
     * @return self
     */
    public function setEnvironment(Environment $environment)
    {
        $this->environment = $environment;

        return $this;
    }

    /**
     * Get the environment
     * @return Environment
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * @param  Session $session
     * @return self
     */
    public function setSession(Session $session)
    {
        $this->session = $session;

        return $this;
    }

    /**
     * Get the session
     * @return Session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param  Cookies $cookies
     * @return self
     */
    public function setCookies(Cookies $cookies)
    {
        $this->cookies = $cookies;

        return $this;
    }

    /**
     * Get the cookies
     * @return Cookies
     */
    public function getCookies()
    {
        return $this->cookies;
    }

    /**
     * Set the request params
     * @param  Params $params
     * @return self
     */
    public function setParams(Params $params)
    {
        $this->params = $params;

        return $this;
    }

    /**
     * Get the request params
     * @return Params
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Set the post params
     * @param  Params $params
     * @return self
     */
    public function setPost(Params $params)
    {
        $this->postParams = $params;

        return $this;
    }

    /**
     * Get the post params
     * @return Params
     */
    public function getPost()
    {
        return $this->postParams;
    }

    /**
     * Set the get params
     * @param  Params $params
     * @return self
     */
    public function setGet(Params $params)
    {
        $this->getParams = $params;

        return $this;
    }

    /**
     * Get the get params
     * @return Params
     */
    public function getGet()
    {
        return $this->getParams;
    }

    /**
     * Informs if request is ajax
     * Alias to isXhr()
     * @see isXhr()
     * @return boolean
     */
    public function isAjax()
    {
        return $this->isXhr();
    }

    /**
     * Informs if request is ajax
     * @return boolean
     */
    public function isXhr()
    {
        return $this->environment['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    /**
     * Get the request method
     * @return string
     */
    public function getMethod()
    {
        $fakeMethod = $this->params['_method'];

        if ($fakeMethod) {
            if (in_array($fakeMethod, $this->acceptedMethods)) {
                return $fakeMethod;
            }

            throw new Exceptions\InvalidRequestMethodException(
                "'$fakeMethod' is not a valid request method"
            );
        }

        return  $this->environment['REQUEST_METHOD'];
    }

    /**
     * Return true when request is POST
     * @return boolean
     */
    public function isPost()
    {
        return $this->getMethod() === self::METHOD_POST;
    }

    /**
     * Return true when request is GET
     * @return boolean
     */
    public function isGet()
    {
        return $this->getMethod() === self::METHOD_GET;
    }

    /**
     * Return true when request is PATCH
     * @return boolean
     */
    public function isPatch()
    {
        return $this->getMethod() === self::METHOD_PATCH;
    }

    /**
     * Return true when request is PUT
     * @return boolean
     */
    public function isPut()
    {
        return $this->getMethod() === self::METHOD_PUT;
    }

    /**
     * Return true when request is DELETE
     * @return boolean
     */
    public function isDelete()
    {
        return $this->getMethod() === self::METHOD_DELETE;
    }
}
