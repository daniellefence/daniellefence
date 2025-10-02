<?php

namespace App;

use Illuminate\Support\Facades\Auth;

class Permission
{
    public function check($permission)
    {
        if (Auth::check() && auth()->user()->hasPermission($permission)) {
            return true;
        }

        return false;
    }

    public function get()
    {
        $return = [
            [
                'category' => 'user',
                'label' => 'Users',
                'actions' => [
                    'create' => 'User can create another user.',
                    'read' => 'User can view the user admin page.',
                    'update' => 'User can update a user.',
                    'delete' => 'User can delete a user.',
                ],
            ],
            [
                'category' => 'googleanalytics',
                'label' => 'Google Analytics',
                'actions' => [
                    'read' => 'User can view Google Analytics page.',
                    'update' => 'User can update Google Analytics code.',
                ],
            ],
            [
                'category' => 'catalogs',
                'label' => 'Catalogs',
                'actions' => [
                    'create' => 'User can create / upload a catalog.',
                    'read' => 'User can view catalog page.',
                    'update' => 'User can update a catalog.',
                    'delete' => 'User can delete a catalog.',
                ],
            ],
            [
                'category' => 'traffic',
                'label' => 'Traffic',
                'actions' => [
                    'read' => 'User can view the traffic admin page.',
                ],
            ],
            [
                'category' => 'career',
                'label' => 'Careers',
                'actions' => [
                    'create' => 'User can create a career.',
                    'read' => 'User can view career admin page.',
                    'update' => 'User can update a career.',
                    'delete' => 'User can delete a career.',
                ],
            ],
            [
                'category' => 'testimonial',
                'label' => 'Testimonials',
                'actions' => [
                    'create' => 'User can create a testimonial.',
                    'read' => 'User can view testimonial admin page.',
                    'update' => 'User can update a testimonial.',
                    'delete' => 'User can delete a testimonial.',
                ],
            ],
            [
                'category' => 'blog',
                'label' => 'Blogs',
                'actions' => [
                    'create' => 'user can create a blog.',
                    'read' => 'User can view blog page.',
                    'update' => 'User can update a blog.',
                    'delete' => 'User can delete a blog.',
                ],
            ],
            [
                'category' => 'blogCategory',
                'label' => 'Blog Categories',
                'actions' => [
                    'create' => 'User can create blog categories.',
                    'read' => 'User can view blog categories.',
                    'delete' => 'User can delete blog categories.',
                ],
            ],
            [
                'category' => 'activity',
                'label' => 'Activity',
                'actions' => [
                    'read' => 'User can view activity page.',
                    'delete' => 'User can delete activity.',
                ],
            ],
            [
                'category' => 'contact',
                'label' => 'Contacts',
                'actions' => [
                    'read' => 'User can view contacts page.',
                    'delete' => 'User can delete contact.',
                ],
            ],
            [
                'category' => 'documentation',
                'label' => 'Documentation',
                'actions' => [
                    'create' => 'User can create documentation.',
                    'read' => 'User can view documentation page.',
                    'update' => 'User can edit documentation.',
                    'delete' => 'User can delete documentation.',
                ],
            ],
            [
                'category' => 'documentationCategory',
                'label' => 'Documentation Categories',
                'actions' => [
                    'create' => 'User can create documentation category.',
                    'read' => 'User can view documentation category page.',
                    'delete' => 'User can delete documentation category.',
                ],
            ],
            [
                'category' => 'review',
                'label' => 'Reviews',
                'actions' => [
                    'create' => 'User can create a review.',
                    'read' => 'User can view reviews page.',
                    'update' => 'User can edit a review.',
                    'delete' => 'User can delete a review.',
                ],
            ],
            [
                'category' => 'faq',
                'label' => 'FAQ',
                'actions' => [
                    'create' => 'User can create an FAQ.',
                    'read' => 'User can view FAQ page.',
                    'update' => 'User can edit a FAQ.',
                    'delete' => 'User can delete a FAQ.',
                ],
            ],
            [
                'category' => 'seo',
                'label' => 'Seo',
                'actions' => [
                    'read' => 'User can view S.E.O. page.',
                    'update' => 'User can update S.E.O. items.',
                ],
            ],
            [
                'category' => 'area',
                'label' => 'Areas We Serve',
                'actions' => [
                    'create' => 'User can create area we serve.',
                    'read' => 'User can view Areas We Serve page.',
                    'delete' => 'User can delete area we serve.',
                ],
            ],
            [
                'category' => 'quoterequests',
                'label' => 'Quote Requests',
                'actions' => [
                    'read' => 'User can view quote requests page.',
                    'delete' => 'User can delete quote request.',
                ],
            ],
            [
                'category' => 'videos',
                'label' => 'Videos',
                'actions' => [
                    'read' => 'User can view videos page.',
                    'create' => 'User can create video.',
                    'delete' => 'User can delete video.',
                ],
            ],
            [
                'category' => 'general',
                'label' => 'General',
                'actions' => [
                    'read' => 'User can read general settings.',
                    'update' => 'User can update general settings.',
                ],
            ],
            [
                'category' => 'specials',
                'label' => 'Specials',
                'actions' => [
                    'create' => 'User can create specials.',
                    'read' => 'User can read specials.',
                    'update' => 'User can update specials.',
                    'delete' => 'User can delete specials.',
                ],
            ],
            [
                'category' => 'product',
                'label' => 'Products',
                'actions' => [
                    'create' => 'User can create a product.',
                    'read' => 'User can read a product.',
                    'update' => 'User can update a product.',
                    'delete' => 'User can delete a product.',
                ],
            ],
            [
                'category' => 'category',
                'label' => 'Product Category',
                'actions' => [
                    'create' => 'User can create a product category.',
                    'read' => 'User can read product categories.',
                    'update' => 'User can update a product category.',
                    'delete' => 'User can delete a product category.',
                ],
            ],
            [
                'category' => 'subcategory',
                'label' => 'Product Subcategory',
                'actions' => [
                    'create' => 'User can create a product subcategory.',
                    'read' => 'User can read a product subcategory.',
                    'update' => 'User can update a product subcategory.',
                    'delete' => 'User can delete a product subcategory.',
                ],
            ],
            [
                'category' => 'areasweserve',
                'label' => 'Areas We Serve',
                'actions' => [
                    'create' => 'User can create an area we serve.',
                    'read' => 'User can read the areas we serve page.',
                    'update' => 'User can update an area we serve.',
                    'delete' => 'User can delete an area we serve.',
                ],
            ],
        ];
        usort($return, function ($item1, $item2) {
            return $item1['category'] <=> $item2['category'];
        });

        return $return;

    }

    public function getListOfPermissions()
    {
        $return = [];
        foreach ($this->get() as $permission) {
            foreach ($permission['actions'] as $action => $label) {
                $return[] = $permission['category'].ucfirst($action);
            }
        }

        return $return;
    }
}
