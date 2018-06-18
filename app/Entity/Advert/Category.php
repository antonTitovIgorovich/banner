<?php

namespace App\Entity\Advert;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;


/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int|null $parent_name
 *
 * @property int $depth
 * @property Category $parent
 * @property Category[] $child
 */
class Category extends Model
{
    use NodeTrait;

    protected $table = 'advert_categories';

    public $timestamps = false;

    protected $fillable = ['name', 'slug', 'parent_id'];
}