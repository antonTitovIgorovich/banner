<?php

namespace App\Http\Controllers\Admin\Adverts;

use App\Http\Requests\Admin\Adverts\AttributeRequest;
use App\Http\Controllers\Controller;
use App\Entity\Adverts\Category;

class CategoryController extends Controller
{
    protected $categories;

    public function __construct()
    {
        $this->categories = Category::defaultOrder()->withDepth()->get();
    }

    public function index()
    {
        return view('admin.adverts.categories.index', ['categories' => $this->categories]);
    }

    public function create()
    {
        return view('admin.adverts.categories.create', ['parents' => $this->categories]);
    }

    public function store(AttributeRequest $request)
    {
        $category = Category::create([
            'name' => $request['name'],
            'slug' => $request['slug'],
            'parent_id' => $request['parent'],
        ]);
        return redirect()->route('admin.adverts.categories.show', $category);
    }

    public function show(Category $category)
    {
        $parentAttributes = $category->parentAttributes();
        $attributes = $category->attributes()->orderBy('sort')->get();

        return view('admin.adverts.categories.show', compact('category', 'attributes', 'parentAttributes'));
    }

    public function edit(Category $category)
    {
        $parents = $this->categories;
        return view('admin.adverts.categories.edit', compact('category', 'parents'));
    }

    public function update(AttributeRequest $request, Category $category)
    {
        $category->update([
            'name' => $request['name'],
            'slug' => $request['slug'],
            'parent_id' => $request['parent'],
        ]);
        return redirect()->route('admin.adverts.categories.show', $category);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.adverts.categories.index');
    }

    public function first(Category $category)
    {
        if ($first = $category->siblings()->defaultOrder()->first()) {
            $category->insertBeforeNode($first);
        }
        return redirect()->route('admin.adverts.categories.index');
    }

    public function up(Category $category)
    {
        $category->up();
        return redirect()->route('admin.adverts.categories.index');
    }

    public function down(Category $category)
    {
        $category->down();
        return redirect()->route('admin.adverts.categories.index');
    }

    public function last(Category $category)
    {
        if ($last = $category->siblings()->defaultOrder('desc')->first()) {
            $category->insertAfterNode($last);
        }
        return redirect()->route('admin.adverts.categories.index');
    }
}
