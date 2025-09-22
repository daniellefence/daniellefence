<?php

namespace App\Http\Controllers;

use App\Models\AreasWeServe;
use App\Models\Blog;
use App\Models\Blogcategory;
use App\Models\Career;
use App\Models\Category;
use App\Models\Documentation;
use App\Models\Documentationcategory;
use App\Models\Faq;
use App\Models\Photo;
use App\Models\Pip;
use App\Models\Product;
use App\Models\Review;
use App\Models\Special;
use App\Models\User;
use App\Models\Video;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DeleteController extends Controller
{
    public function delete()
    {
        //        gateway

        $guid = request()->input('guid');
        $type = request()->input('type');
        switch ($type) {
            case 'pip':
                $item = Pip::findOrFail($guid);
                $item->delete();
                break;
            case 'photo':
                $item = Photo::findOrFail($guid);
                $ids = [
                    'category_id',
                    'subcategory_id',
                    'product_id',
                    'blog_id',
                    'review_id',
                    'carousel_id',
                    'special_id',
                ];
                foreach ($ids as $id) {
                    if (isset($item->$id)) {
                        switch ($id) {
                            case 'category_id':
                                if (permission()->check('categoryDelete')) {
                                    $item->delete();
                                }
                                break;
                            case 'subcategory_id':
                                if (permission()->check('subcategoryDelete')) {
                                    $item->delete();
                                }
                                break;
                            case 'product_id':
                                if (permission()->check('productDelete')) {
                                    $item->delete();
                                }
                                break;
                            case 'blog_id':
                                if (permission()->check('blogDelete')) {
                                    $item->delete();
                                }
                                break;
                            case 'review_id':
                                if (permission()->check('reviewDelete')) {
                                    $item->delete();
                                }
                                break;
                            case 'carousel_id':
                                if (permission()->check('carouselUpdate')) {
                                    $item->delete();
                                }
                                break;
                            case 'special_id':
                                if (permission()->check('specialsDelete')) {
                                    $item->delete();
                                }
                                break;
                        }
                    }
                }

                if (permission()->check('photoDelete')) {

                    activity()->create($item, 'delete');
                    $item->delete();
                }
                break;
            case 'specials':
                if (permission()->check('specialsDelete')) {
                    $item = Special::findOrFail($guid);
                    activity()->create($item, 'delete');
                    $item->delete();
                }
                break;
            case 'user':
                if (permission()->check('userDelete')) {
                    $item = User::findOrFail($guid);
                    if (! $item->isSuperUser()) {
                        activity()->create($item, 'delete');
                        $item->delete();
                    }
                }
                break;
            case 'blog':
                if (permission()->check('blogDelete')) {
                    $item = Blog::findOrFail($guid);
                    activity()->create($item, 'delete');
                    $item->delete();
                }
                break;
            case 'career':
                if (permission()->check('careerDelete')) {
                    $item = Career::findOrFail($guid);
                    activity()->create($item, 'delete');
                    $item->delete();
                }
                break;
            case 'documentationCategory':
                if ($guid != 1) {
                    if (permission()->check('documentationCategoryDelete')) {
                        $item = Documentationcategory::findOrFail($guid);
                        activity()->create($item, 'delete');
                        $item->delete();
                    }
                } else {
                    toast()->warning("General category can't be deleted.");
                }
                break;
            case 'area':
                if (permission()->check('areaDelete')) {
                    $item = AreasWeServe::findOrFail($guid);
                    activity()->create($item, 'delete');
                    $item->delete();
                }
                break;
            case 'video':
                if (permission()->check('videosDelete')) {
                    $item = Video::findOrFail($guid);
                    activity()->create($item, 'delete');
                    $item->delete();
                }
                break;
            case 'blogCategory':
                if ($guid != 1) {
                    if (permission()->check('blogCategoryDelete')) {
                        $item = Blogcategory::findOrFail($guid);
                        activity()->create($item, 'delete');
                        $item->delete();
                    }
                } else {
                    toast()->warning("General category can't be deleted.");
                }
                break;
            case 'documentation':
                if (permission()->check('documentationDelete')) {
                    $item = Documentation::findOrFail($guid);
                    activity()->create($item, 'delete');
                    $item->delete();
                }
                break;
            case 'carouselPhoto':
                if (permission()->check('carouselPhotoDelete')) {
                    $item = Photo::findOrFail($guid);
                    activity()->create($item, 'delete');
                    $item->delete();
                }
                break;
            case 'review':
                if (permission()->check('reviewDelete')) {
                    $item = Review::findOrFail($guid);
                    activity()->create($item, 'delete');
                    $item->delete();
                }
                break;
            case 'seo':
                if (permission()->check('seoDelete')) {
                    $item = \App\Models\Seo::findOrFail($guid);
                    activity()->create($item, 'delete');
                    $item->delete();
                }
                break;
            case 'category':
                if (permission()->check('categoryDelete')) {
                    $item = Category::findOrFail($guid);
                    activity()->create($item, 'delete');
                    $item->delete();
                }
                break;
            case 'subcategory':
                if (permission()->check('subcategoryDelete')) {
                    $item = Category::findOrFail($guid);
                    activity()->create($item, 'delete');
                    $item->delete();
                }
                break;
            case 'product':
                if (permission()->check('productDelete')) {
                    $item = Product::findOrFail($guid);
                    activity()->create($item, 'delete');
                    $item->delete();
                }
                break;
            case 'faq':
                if (permission()->check('faqDelete')) {
                    $item = Faq::findOrFail($guid);
                    activity()->create($item, 'delete');
                    $item->delete();
                }
                break;
            case 'role':
                if (permission()->check('userDelete')) {
                    $item = Role::findOrFail($guid);
                    // Prevent deletion of roles that still have users assigned
                    if ($item->users()->count() > 0) {
                        toast()->warning("Cannot delete role '{$item->name}' because it is assigned to " . $item->users()->count() . " user(s).");
                        return redirect()->back();
                    }
                    activity()->create($item, 'delete');
                    $item->delete();
                }
                break;
            case 'permission':
                if (permission()->check('userDelete')) {
                    $item = Permission::findOrFail($guid);
                    // Prevent deletion of permissions that are still assigned to roles
                    if ($item->roles()->count() > 0) {
                        toast()->warning("Cannot delete permission '{$item->name}' because it is assigned to " . $item->roles()->count() . " role(s).");
                        return redirect()->back();
                    }
                    activity()->create($item, 'delete');
                    $item->delete();
                }
                break;
        }

        return redirect()->back();
    }
}
