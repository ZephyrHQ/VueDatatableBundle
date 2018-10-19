# VueDatatableBundle #

## Installation ##

```shell
composer require zephyrhq/vue_datatable_bundle
```

## Configuration ##

```yaml
vue_datatable:
    # The vue-table2 server processing route
    vue_table2_route_name: vuetable2_process
```

## Usage ##

### With Manager ###

```php
public function productDataAction(Request $request): Response
{
    $datatable = $this->get(Datatable{Manager|Provider|Factory|Builder}::class)->getDatatable(DatatableType::class);

    return $datatable->handleRequest($request)->getResponse();
}
```

### Directly In controller ###

Create a provider that is responsible to retrieve the data from a database or whatever, juste implements the DatatableProviderInterface.

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

        return new ArrayResultSet($data, \count($data), \count($data));
    }
}
```

In a controller :

```php
public function vuetable2Process(Request $request,
    DatatableInteractorInterface $datatableInteractor,
    ProductProvider $productProvider): Response
{
    $datatable = (new Datatable())
        ->addColumn(new StringColumn('toto'))
        ->addColumn(new StringColumn('description'))
        ->setProvider($productProvider)
    ;
    $dtResult = $datatableInteractor->handleRequest($datatable, $request);
    $response = $datatableInteractor->createResponse($datatable, $dtResult);

    return $response;
}
```
