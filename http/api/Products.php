<?php namespace Voilaah\MallApi\Http\Api;

use Request;
use Backend\Classes\Controller;
use OFFLINE\Mall\Models\Product;
use OFFLINE\Mall\Models\Variant;
use OFFLINE\Mall\Models\Category;
use Illuminate\Support\Collection;
use OFFLINE\Mall\Classes\Index\Index;
use Illuminate\Pagination\LengthAwarePaginator;
use Voilaah\MallApi\Interfaces\ResourceInterface;
use OFFLINE\Mall\Classes\CategoryFilter\SetFilter;
use OFFLINE\Mall\Classes\CategoryFilter\QueryString;
use Voilaah\MallApi\Classes\Transformers\ProductTransformer;
use Voilaah\MallApi\Classes\Transformers\VariantTransformer;
use Voilaah\MallApi\Classes\CategoryFilter\SortOrder\SortOrder;
use OFFLINE\Mall\Classes\CategoryFilter\SortOrder\SortOrder as MallSortOrder;

/**
 * Products Back-end Controller
 */
class Products extends Controller implements ResourceInterface
{
    use \OFFLINE\Mall\Classes\Traits\HashIds;

    protected $categorySlug;
    protected $category;
    protected $categories;

    protected $includeVariants;

    protected $isVariant;
    protected $variantId;
    protected $variant;
    protected $productId;
    protected $product;

    public $filter;

    /**
     * How many items to show per page.
     *
     * @var integer
     */
    public $perPage;

    /**
     * The current page number.
     *
     * @var integer
     */
    public $pageNumber;

    public $implement = [
        'Voilaah.MallApi.Behaviors.RestController'
    ];

    public $restConfig = 'config_rest.yaml';


    /**
     * override the index function
     * code coming for the function getItems from the MALL component Products
     *
     * @return [type] [description]
     */
    public function index($categorySlug = null)
    {

        $this->categorySlug = $categorySlug;

        $options        = $this->getConfig()->allowedActions['index'];
        $page           = Request::input('page', 1);

        /*
         * Default options
         */
        extract(array_merge([
            'page'       => $page,
            'pageSize'    => 5
        ], $options));

        $this->perPage = $pageSize;
        $this->pageNumber = $page;

        $this->category     = $this->getCategory();

        if ($this->category) {
            $categories = collect([$this->category]);
            if (true /*$this->includeChildren*/) {
                $categories = $this->category->getAllChildrenAndSelf();
            }

            $this->categories = $categories;
        }

        $filters            = $this->getFilters();
        $sortOrder          = $this->getSortOrder();

        $model    = $this->includeVariants() ? new Variant() : new Product();
        $useIndex = $this->includeVariants() ? 'variants' : 'products';
        $transformer = $this->includeVariants() ? new VariantTransformer : new ProductTransformer;

        $sortOrder->setFilters(clone $filters);

        /** @var Index $index */
        $index  = app(Index::class);
        $result = $index->fetch($useIndex, $filters, $sortOrder, $this->perPage, $this->pageNumber);

        // Every id that is not an int is a "ghosted" variant, with an id like
        // product-1. These ids have to be fetched separately. This enables us to
        // query variants and products that don't have any variants from the same index.
        $itemIds  = array_filter($result->ids, 'is_int');
        $ghostIds = array_diff($result->ids, $itemIds);

        $models = $model->with($this->productIncludes())->find($itemIds);
        $ghosts = $this->getGhosts($ghostIds);

        // Preload all pricing information for related products. This is used in case a Variant
        // is inheriting it's parent product's pricing information.
        if ($model instanceof Variant) {
            $models->load(['product.customer_group_prices', 'product.prices', 'product.additional_prices']);
        }

        // Insert the Ghost models back at their old position so the sort order remains.
        $resultSet = collect($result->ids)->map(function ($id) use ($models, $ghosts) {
            return is_int($id)
                ? $models->find($id)
                : $ghosts->find(str_replace('product-', '', $id));
        });

        $data = $this->paginate(
            $resultSet,
            $result->totalCount
        );

        return $this->respondWithCollection($data, $transformer, 200);

    }



    /**
     * Retrieve the Category by ID or from the page's :slug parameter.
     *
     * @return CategoryModel|null
     */
    protected function getCategory()
    {
        if ($this->category) {
            return $this->category;
        }

        if ($this->categorySlug === null) {
            return null;
        }

        // if ($this->property('category') === ':slug' && $this->param('slug') === null) {
        //     throw new \LogicException(
        //         'Voilaah.MallApi: A :slug URL parameter is needed when selecting products by category slug.'
        //     );
        // }
        $isId = is_numeric($this->categorySlug) ? $this->categorySlug : ":slug";
        return Category::bySlugOrId($this->categorySlug, $isId);
    }


    /**
     * Paginate the result set.
     *
     * @param Collection $items
     * @param int        $totalCount
     *
     * @return LengthAwarePaginator
     */
    protected function paginate(Collection $items, int $totalCount)
    {
        $paginator = new LengthAwarePaginator(
            $items,
            $totalCount,
            $this->perPage,
            $this->pageNumber
        );

        $paginator->appends(request()->all());

        // $pageUrl = $this->getController()->pageUrl(
        //     'products.show',
        //     ['slug' => ':slug']
        // );

        $pageUrl = route('products.index');

        return $paginator->setPath($pageUrl);
    }


    /**
     * @deprecated
     * @return [type] [description]
     */
    public function includeVariants()
    {
        if ($this->includeVariants)
            return $this->includeVariants;
        $value = Request::input('includeVariants', "false");
        $this->includeVariants = filter_var($value, FILTER_VALIDATE_BOOLEAN);
        return $this->includeVariants;
    }



    /**
     * Deserialize the URL parameter into Filter classes.
     *
     * @return Collection
     */
    protected function getFilters(): Collection
    {
        $filter = request()->all();

        if ($this->filter) {
            parse_str($this->filter, $filter);
        }

        $filter = array_wrap($filter);

        $filters = (new QueryString())->deserialize($filter, $this->category);

        $this->setFilters($filters);
        if ($this->categories) {
            $filters->put('category_id', new SetFilter('category_id', $this->categories->pluck('id')->toArray()));
        }

        return $filters;
    }


    /**
     * Get the sort order selected by the shop admin or the user.
     * Use fallback if neither is present.
     *
     * @return SortOrder
     */
    protected function getSortOrder()
    {
        $options = $this->getConfig()->allowedActions['index'];
        $key = isset($options['sortOrder']) ? $this->getSortKeyOrder($options['sortOrder']) : $this->getSortKeyOrder();
        // $key = input('sort', $this->property('sort') ?? SortOrder::default());
        $this->setSortKey($key);
        return SortOrder::fromKey($key);
    }

    protected function getSortKeyOrder($sortOrder = null)
    {
        $key = Request::input('sort', $sortOrder);
        if (! $key)
            $key =  SortOrder::default();
        return $key;
    }

    /**
     * Return an array of default Product includes.
     *
     * @return array
     */
    protected function productIncludes(): array
    {
        return ['translations', 'image_sets.images', 'customer_group_prices', 'additional_prices'];
    }


    /**
     * Fetch all ghost products.
     *
     * Products that don't have any Variants are still stored in the
     * Variants index to make it easier to query everything at once.
     * This method removes the product-X prefix from the ID and fetches
     * the effective Product models to display.
     *
     * @param array $ids
     *
     * @return Collection
     */
    protected function getGhosts(array $ids)
    {
        if (count($ids) < 1) {
            return collect([]);
        }

        $ids = array_map(function ($id) {
            return (int)str_replace('product-', '', $id);
        }, $ids);

        return Product::with($this->productIncludes())->find($ids);
    }




    /**
     * Finds a Model record by its primary identifier, used by show, update actions.
     * This logic can be changed by overriding it in the rest controller.
     * @param string $recordId
     * @return Model
     */
    public function findModelObject($recordId)
    {
        if (!strlen($recordId)) {
            throw new Exception('Record ID/slug has not been specified.');
        }

        $this->variantId = null;
        $recordId = trim($recordId, ' /');
        $array = explode('/', $recordId);

        $this->isVariant = (count($array) == 2);

        $this->productId = $this->isVariant ? reset($array) : $recordId;
        $this->product = $this->getProduct();

        if ($this->isVariant) {
            // $productId = reset($array);
            $variant = end($array);
            $this->variantId = $this->decode($variant);
            $this->getVariant();
            if (!$this->variant) {
                throw new Exception(sprintf('Variant Record with an ID/slug of %u could not be found.', $this->variantId));
            }
            return $this->variant;
        } else {
            if (!$this->product) {
                throw new Exception(sprintf('Product Record with an ID/slug of %u could not be found.', $this->productId));
            }
            return $this->product;
        }

    }

    protected function getProduct($with = null)
    {
        if ($this->product) {
            return $this->product;
        }

        if ($with === null) {
            $with = [
                'variants',
                'variants.property_values.translations',
                'variants.image_sets',
                'image_sets',
                'downloads',
                'categories',
                'property_values.property.property_groups',
                'services.options',
                'taxes',
            ];
        }

        $model = new Product;

        // $product = $this->property('product');
        $query   = Product::published()->with($with);

        // if ($product === ':slug') {
            // $method = $this->rainlabTranslateInstalled() ? 'transWhere' : 'where';
            $query = $query->where('id', $this->productId);
            if (property_exists($model, 'slug') || in_array('slug', $model->fillable)) {
                $query->orWhere('slug', $this->productId);
            }
            return $query->first();
            // return $model->where('slug', $this->param('slug'))->firstOrFail();
        // }

        // return $model->findOrFail($product);

    }

    protected function getVariant($value='')
    {
        $variantModel = Variant::published()->with([
            'property_values.translations',
            'property_values.property.property_groups',
            'product_property_values.property.property_groups',
            'image_sets',
        ]);
        return $this->variant = $variantModel->where('product_id', $this->product->id)->findOrFail($this->variantId);

    }

    public function createTransformerObject()
    {
        return $this->isVariant ? new VariantTransformer : new ProductTransformer;
    }

    /**
     * Return the resource name used by the controller
     * @return mixed
     */
    public function getResourceName() {
        return $this->isVariant ? 'variants' : 'products';
    }

}
