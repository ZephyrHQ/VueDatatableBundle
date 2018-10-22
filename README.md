# VueDatatableBundle #

## Installation ##

```shell
composer require zephyrhq/vue_datatable_bundle
```

## Configuration ##

No config yet.

## Usage ##

Create a provider that is responsible to retrieve the data from a database or whatever, just implements the `DatatableProviderInterface`.

```php
namespace App\DatatableProvider;

use VueDatatableBundle\Domain\Datatable;
use VueDatatableBundle\Domain\Provider\ArrayResultSet;
use VueDatatableBundle\Domain\Provider\DatatableProviderInterface;
use VueDatatableBundle\Domain\Provider\ResultSetInterface;

class ProductProvider implements DatatableProviderInterface
{
    public function getResult(Datatable $datatable): ResultSetInterface
    {
        $datatableRequest = $datatable->getRequest();

        // from a database or whatever
        $data = [
            [
                'id' => '1',
                'name' => 'Sofa',
                'price' => 102.99,
                'vat' => 0.2,
                'availableQuantity' => 50,
            ],
            [
                'id' => '2',
                'name' => 'Table',
                'price' => 50.65,
                'vat' => 0.2,
                'availableQuantity' => 3,
            ],
            [
                'id' => '3',
                'name' => 'TV',
                'price' => 550.0,
                'vat' => 0.2,
                'availableQuantity' => 999,
            ],
        ];

        $totalCount = \count($data);

        // order, filter and paginate as you need
        $data = \array_slice($data, ($datatableRequest->page - 1) * $datatableRequest->perPage, $datatableRequest->perPage);

        return new ArrayResultSet($data, $totalCount, $totalCount);
    }
}
```

Create a type for composing your datatable. Just extends `AbstractDatatableType`. 

```php
namespace App\DatatableType;

use App\DatatableProvider\ProductProvider;
use VueDatatableBundle\Domain\Column\SimpleColumn;
use VueDatatableBundle\Domain\Datatable;
use VueDatatableBundle\Domain\Type\AbstractDatatableType;

class ProductDatatableType extends AbstractDatatableType
{
    /**
     * @var ProductProvider
     */
    private $productProvider;

    public function __construct(ProductProvider $productProvider)
    {
        $this->productProvider = $productProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function configure(Datatable $datatable): void
    {
        $datatable
            ->setProvider($this->productProvider)
            ->addColumn('title', SimpleColumn::class, [])
            ->addColumn('description', SimpleColumn::class, [])
            ->addColumn('date', SimpleColumn::class, []);
    }
}
```

Finally, in a controller :

```php
public function vuetable2Process(Request $request,
    DatatableInteractorInterface $datatableInteractor,
    DatatableFactory $datatableFactory): Response
{
    $datatable = $datatableFactory->createFromType(ProductDatatableType::class);
    $dtResult = $datatableInteractor->handleRequest($datatable, $request);

    return $datatableInteractor->createResponse($datatable, $dtResult);
}
```
