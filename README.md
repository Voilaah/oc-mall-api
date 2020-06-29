# RESTFUL API for October CMS OFFLINE MALL plugin

**Work in progress**

Plugins Required:
- RainLab.User
- OFFLINE.Mall
- OFFLINE.SiteSearch
- RLuders.JWTAuth
- RLuders.CORS

**This API is based on the first version of this plugin https://github.com/SaifurRahmanMohsin/oc-rest-plugin**


<a name="overview"></a>
# API Overview

### Notes

`{slug*}` means a string following the pattern `{slug}` or `{slug1}/{slug2}`

`{categorySlug*}` means a string following the pattern `{categorySlug}` or `{categorySlug1}/{categorySlug2}`

`{brandSlug}` means a simple string

`{id}` means a numeric value

---

### Full Documentation

URL: `/api/mall/docs`

### Shop

**Settings**
- [ ] `GET /api/mall/settings`

**Shippings**
- [ ] `GET /api/mall/shippings`
- [ ] `GET /api/mall/shippings/{slug*}` or `GET /api/mall/shippings/{id}`

**Payments**
- [ ] `GET /api/mall/payments`
- [ ] `GET /api/mall/payments/{slug*}` or `GET /api/mall/payments/{id}`

**Brands**
- [x] `GET /api/mall/brands`
- [x] `GET /api/mall/brands/{slug*}` or `GET /api/mall/brands/{id}`

**Discounts list**
- [ ] `GET /api/mall/discounts`

**Categories list**
- [x] `GET /api/mall/categories`
- [x] `GET /api/mall/categories/{slug*}` OR `GET /api/mall/categories/{id}`
- [x] `GET /api/mall/categories/{slug*}/filters` OR `GET /api/mall/categories/{id}/filters`
- [x] `GET /api/mall/categories/{slug*}/products` OR `GET /api/mall/categories/{id}/products`

**Products list**
- [x] `GET /api/mall/products`

**Products sorting options**
- [x] `GET /api/mall/products?sort=latest`
- [x] `GET /api/mall/products?sort=oldest`
- [x] `GET /api/mall/products?sort=bestseller`
- [x] `GET /api/mall/products?sort=ratings`
- [x] `GET /api/mall/products?sort=price`
- [x] `GET /api/mall/products?sort=price_high`
- [x] `GET /api/mall/products?sort=price_low`
- [x] `GET /api/mall/products?sort=name_asc`
- [x] `GET /api/mall/products?sort=name_desc`

**Universal filters available for all products**
- [x] `GET /api/mall/products?on_sale=true`
- [x] `GET /api/mall/products?brand={brandSlug}` (Ex: /api/mall/products?brand=cruiser-bikes)
- [x] `GET /api/mall/products?brand={brandSlug}&on_sale=true` (Ex: /api/mall/products?brand=cruiser-bikes&on_sale=true)
- [x] `GET /api/mall/products?price=700.00-1000.00` (range value)

**Products by category and filters**
- [x] `GET /api/mall/products/category/{categorySlug*}` (Ex: /api/mall/products/category/bikes or /api/mall/products/category/bikes/citybikes)
- [x] `GET /api/mall/products/category/{categorySlug*}?sort=name_desc`
- [x] `GET /api/mall/products/category/{categorySlug*}?gender=female` (Ex: /api/mall/products/category/bikes?gender=female)

**Products details**
- [x] `GET /api/mall/products/{slug*}` OR `GET /api/mall/products/{id}`

**Variants details**
- [x] `GET /api/mall/variants/{slug*}` OR `GET /api/mall/variants/{id}`



### Cart &amp; Checkout process

- [x] `GET /api/mall/cart`
- [x] `POST /api/mall/cart`
- [ ] `PUT /api/mall/cart/{cartItemId}`
- [ ] `DELETE /api/mall/cart/{cartItemId}`
- [ ] `POST /api/mall/checkout`


### Authentication and customers profiles

- [x] `POST /api/mall/auth/register`
- [x] `POST /api/mall/auth/account-activation`
- [x] `POST /api/mall/auth/forgot-password`
- [x] `POST /api/mall/auth/reset-password`
- [x] `POST /api/mall/auth/refresh-token`
- [x] `POST /api/mall/auth/login`
- [x] `GET /api/mall/auth/me`
- [ ] `GET /api/mall/auth/me/customer`
- [ ] `PUT /api/mall/auth/me/customer`
- [ ] `GET /api/mall/auth/me/addresses`
- [ ] `GET /api/mall/auth/me/addresses/{id}`
- [ ] `POST /api/mall/auth/me/addresses`
- [ ] `PUT /api/mall/auth/me/addresses/{id}`
- [ ] `DELETE /api/mall/auth/me/addresses/{id}`
- [ ] `GET /api/mall/auth/me/orders`
- [ ] `GET /api/mall/auth/me/orders/{id}`
- [ ] `GET /api/mall/auth/me/wishlist`
- [ ] `DELETE /api/mall/auth/me/wishlist/{id}`



### Routes caching

To enhance performances, type this command in your console

`php artisan route:cache`
