<?php

namespace App\Manager;
class SidebarManager
{
    private static array $routes = [
        'product'            => ['product.index', 'product.show', 'product.create', 'product.edit', 'product.update'],
        'category'           => ['category.index', 'category.show', 'category.create', 'category.edit', 'category.update'],
        'manufacture'        => ['manufacture.index', 'manufacture.show', 'manufacture.create', 'manufacture.edit', 'manufacture.update'],
        'warehouses'         => ['warehouses.index', 'warehouses.show', 'warehouses.create', 'warehouses.edit', 'warehouses.update'],
        'vendor'             => ['vendor.index', 'vendor.show', 'vendor.create', 'vendor.edit', 'vendor.update'],
        'attribute'          => ['attribute.index', 'attribute.show', 'attribute.create', 'attribute.edit', 'attribute.update'],
        'attribute-value'    => ['attribute-value.index', 'attribute-value.show', 'attribute-value.create', 'attribute-value.edit', 'attribute-value.update'],
        'estimate-category'  => ['estimate-category.index', 'estimate-category.show', 'estimate-category.create', 'estimate-category.edit', 'estimate-category.update'],
        'estimate-sub-category'  => ['estimate-sub-category.index', 'estimate-sub-category.show', 'estimate-sub-category.create', 'estimate-sub-category.edit', 'estimate-sub-category.update'],
        'estimate-package'  => ['estimate-package.index', 'estimate-package.show', 'estimate-package.create', 'estimate-package.edit', 'estimate-package.update'],
        'unit-price'        => ['unit-price.index', 'unit-price.show', 'unit-price.create', 'unit-price.edit', 'unit-price.update'],
        'estimation-lead'   => ['estimation-lead.index', 'estimation-lead.show'],
        'payment-method'    => ['payment-method.index', 'payment-method.show', 'payment-method.create', 'payment-method.edit', 'payment-method.update'],
        'role'              => ['role.index', 'role.show', 'role.create', 'role.edit', 'role.update'],
        'user'              => ['user.index', 'user.show', 'user.edit', 'user.update'],
        'customer-group'    => ['customer-group.index', 'customer-group.create', 'customer-group.edit', 'customer-group.update'],
        'user-customer'     => ['user-customer-group-edit','user-customer.group'],
        'unit'              => ['unit.index', 'unit.show', 'unit.create', 'unit.edit', 'unit.update'],
        'faq-pages'         => ['faq-pages.index', 'faq-pages.show', 'faq-pages.create', 'faq-pages.edit', 'faq-pages.update'],
        'faq'               => ['faq.index', 'faq.show', 'faq.create', 'faq.edit', 'faq.update'],
        'blog-category'     => ['blog-category.index', 'blog-category.show', 'blog-category.create', 'blog-category.edit', 'blog-category.update'],
        'blog-post'         => ['blog-post.index', 'blog-post.show', 'blog-post.create', 'blog-post.edit', 'blog-post.update'],
        'social'            => ['social.index', 'social.show', 'social.create', 'social.edit', 'social.update'],
        'banner-size'       => ['banner-size.index', 'banner-size.show', 'banner-size.create', 'banner-size.edit', 'banner-size.update'],
        'banner'            => ['banner.index', 'banner.show', 'banner.create', 'banner.edit', 'banner.update'],
        'client-logo'       => ['client-logo.index', 'client-logo.show', 'client-logo.create', 'client-logo.edit', 'client-logo.update'],
        'photo-gallery'     => ['photo-gallery.index', 'photo-gallery.show', 'photo-gallery.create', 'photo-gallery.edit', 'photo-gallery.update'],
        'team'              => ['team.index', 'team.show', 'team.create', 'team.edit', 'team.update'],
        'our-approach-category'=> ['our-approach-category.index', 'our-approach-category.show', 'our-approach-category.create', 'our-approach-category.edit', 'our-approach-category.update'],
        'our-approach'         => ['our-approach.index', 'our-approach.show', 'our-approach.create', 'our-approach.edit', 'our-approach.update'],
        'project-category'     => ['project-category.index', 'project-category.show', 'project-category.create', 'project-category.edit', 'project-category.update'],
        'our-project'          => ['our-project.index', 'our-project.show', 'our-project.create', 'our-project.edit', 'our-project.update'],
        'tag'                  => ['tag.index', 'tag.show', 'tag.create', 'tag.edit', 'tag.update'],
        'web-content'          => ['web-content.index', 'web-content.show', 'web-content.create', 'web-content.edit', 'web-content.update'],
        'news-letter'          => ['news-letter.index', 'news-letter.show', 'news-letter.create', 'news-letter.edit', 'news-letter.update'],
        'visitor'              => ['visitor.index'],
        'order'                => ['order.index', 'order.create', 'order.show', 'order.edit'],
        'courier'              => ['couriers.index', 'couriers.create', 'couriers.edit'],
        'division'             => ['division.index', 'division.create', 'division.edit'],
        'city'                 => ['city.index', 'city.create', 'city.edit'],
        'zone'                 => ['zone.index', 'zone.create','zone.edit'],
    ];

    public static function dropdownListSelected(string $route, string $name): string
    {
        $class = '';
        if (in_array($route, self::$routes[$name], true)) {
            $class = 'class="mm-active"';
        }
        return $class;
    }
}
