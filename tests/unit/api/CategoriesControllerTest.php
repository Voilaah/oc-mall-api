<?php

namespace Voilaah\MallApi\Tests\Unit\Api;

use Auth;
use Event;
use OFFLINE\Mall\Models\Category;
use Voilaah\MallApi\Tests\PluginTestCase;

class CategoriesControllerTest extends PluginTestCase
{
    public $parent;
    public $child;
    public $nestedChild;

    public function setUp()
    {
        parent::setUp();
        $parent       = new Category();
        $parent->name = 'Parent';
        $parent->slug = 'parent';
        $parent->save();

        $this->parent = $parent;

        $child            = new Category();
        $child->name      = 'Child of parent';
        $child->parent_id = $parent->id;
        $child->slug      = 'child';
        $child->save();

        $this->child = $child;

        try {
            $nestedChild         = new Category();
            $nestedChild->name   = 'Child of the child';
            $nestedChild->parent = $child->id;
            $nestedChild->slug   = 'child';
            $nestedChild->save();
            // Overwrite the auto fixed child-2 slug
            $nestedChild->slug = 'child';
            $nestedChild->save();
        } catch (\Throwable $e) {
            dd($e);
        }

        $this->nestedChild = $nestedChild;
    }

    /**
     * Tests
     *
     *
     */

	public function test_fetching_categories_list()
    {
        $response = $this->get('/api/mall/api/categories');

        $data = json_decode($response->getContent());
        $this->assertEquals(1, count($data));

        $response->assertStatus(200);
    }

    public function test_fetching_categories_detail_by_slug()
    {
        $response = $this->get('/api/mall/api/categories/parent');

        $data = json_decode($response->getContent());
        $this->assertEquals(1, count($data));
        $this->assertEquals($this->parent->id, $data[0]->id);
        $this->assertEquals($category->id, $data[0]->id);

        $response->assertStatus(200);
    }

    public function test_fetching_categories_detail_by_nestedslug()
    {
        $response = $this->get('/api/mall/api/categories/parent');

        $response->assertStatus(200);
    }


}
