<?php

declare(strict_types=1);

namespace VueDatatableBundle\Domain;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Flex\Response;
use VueDatatableBundle\Domain\Column\AbstractColumn;
use VueDatatableBundle\Domain\Provider\DatatableProviderInterface;
use VueDatatableBundle\Domain\Provider\ResultSetInterface;
use VueDatatableBundle\Domain\DatatableInteractor;

/**
 * Class Datatable.
 *
 * @author Thomas Talbot <thomas.talbot@zephyr-web.fr>
 */
class Datatable
{
    /**
     * @var int
     */
    public $defaultPage = 1;
    /**
     * @var int
     */
    public $defaultPerPage = 10;
    /**
     * @var DatatableInteractor
     */
    protected $interactor;
    /**
     * @var ResultSetInterface
     */
    protected $resultSet;
    /**
     * @var AbstractColumn[]
     */
    protected $columns;

    /**
     * @var DatatableRequest
     */
    protected $request;

    /**
     * @var DatatableRequest
     */
    protected $routeName;

    /**
     * @var DatatableProviderInterface
     */
    protected $provider;

    /**
     * @var callable
     */
    protected $formatter;
    
    /**
     * @param RouterInterface $router
     * @param string          $routeName the route name for generating the nextPageUrl and prevPageUrl
     */
    public function __construct(DatatableInteractor $interactor)
    {
        $this->interactor = $interactor;
    }

    public function getProvider(): ?DatatableProviderInterface
    {
        return $this->provider;
    }

    public function setProvider(DatatableProviderInterface $provider): self
    {
        $this->provider = $provider;

        return $this;
    }

    public function createProvider($class, $options): self
    {
        $this->provider = new $class($options['entity']);

        return $this;
    }

    public function setFormatter(callable $formatter): self
    {
        $this->formatter = $formatter;

        return $this;
    }

    public function getFormatter(): ?callable
    {
        return $this->formatter;
    }

    public function add(string $name, string $class, ?array $options = []): self
    {
        $this->columns[$name] = new $class($name, $options);

        return $this;
    }

    public function getColumn(string $name): AbstractColumn
    {
        return $this->columns[$name];
    }

    /**
     * Get Request.
     *
     * @return DatatableRequest|null
     */
    public function getRequest(): ?DatatableRequest
    {
        return $this->request;
    }
    
    /**
     * @return bool
     */
    public function isCallback(): bool
    {
        return $this->request->isCallback;
    }

    /**
     * {@inheritdoc}
     */
    public function handleRequest(Request $request): Datatable
    {
        $this->request = $this->interactor->handleRequest($this, $request);

        return $this;
    }

    public function getResponse(): \Symfony\Component\HttpFoundation\Response
    {
        return $this->interactor->createResponse($this);
    }
}
