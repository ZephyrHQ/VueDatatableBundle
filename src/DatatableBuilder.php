<?php

declare(strict_types=1);

namespace VueDatatableBundle;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\RouterInterface;
use VueDatatableBundle\Domain\Datatable;
use VueDatatableBundle\Domain\DatatableInteractor;
use VueDatatableBundle\Domain\Provider\DatatableProviderInterface;
use VueDatatableBundle\Domain\Provider\ORMAble;
use VueDatatableBundle\Domain\Type\DatatableTypeInterface;
use VueDatatableBundle\Domain\Type\TypeRegistry;
use VueDatatableBundle\Domain\Type\VueTable2TypeInterface;
use VueDatatableBundle\InputProcessor\VueTable2InputProcessor;
use VueDatatableBundle\Presenter\VueTable2Presenter;
use Zend\EventManager\Exception\InvalidArgumentException;

/**
 * Class VueTable2Presenter.
 *
 * @see https://ratiw.github.io/vuetable-2/#/Data-Format-JSON
 *
 * @author Thomas Talbot <thomas.talbot@zephyr-web.fr>
 */
class DatatableBuilder
{
    /**
     * @var RouterInterface
     */
    protected $router;
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;
    /**
     * @var TypeRegistry
     */
    protected $registry;

    /**
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router, EntityManagerInterface $entityManager, TypeRegistry $registry)
    {
        $this->router = $router;
        $this->entityManager = $entityManager;
        $this->registry = $registry;
    }

    public function createFromType(string $typeClass, array $options): Datatable
    {
        /** @var $type \VueDatatableBundle\Domain\DatatableTypeInterface */
//        if (!class($typeClass, AbstractDatatableType::class)) {
//            throw new \RuntimeException(sprintf('$typeClass must be an %s object, %s given.', AbstractDatatableType::class, $typeClass));
//        }
        $type = $this->registry->getType($typeClass);

        $interactor = $this->getInteractor($type);
        $datatable = new Datatable($interactor);
        $type->configure($datatable, $options);
        $provider = $type->getProvider();
        $this->injectProviderDependencies($provider);
        $datatable->setProvider($provider);

        return $datatable;
    }

    protected function getInteractor(DatatableTypeInterface $type)
    {
        if($type instanceof VueTable2TypeInterface){
            $inputProcessor = new VueTable2InputProcessor();
            $presenter = new VueTable2Presenter($this->router);
            
            return new DatatableInteractor($inputProcessor, $presenter);
        }
        throw new InvalidArgumentException('The type should implements one of there DatatabletypeInterface: VueTable2TypeInterface');
    }

    protected function injectProviderDependencies(DatatableProviderInterface $provider)
    {
        if($provider instanceof ORMAble) {
            $provider->setEntityManager($this->entityManager);
        }
    }

}
