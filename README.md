# RESTFUL API for October CMS OFFLINE MALL plugin


Plugins Required:
- RainLab.User
- OFFLINE.Mall
- OFFLINE.SiteSearch
- RLuders.JWTAuth
- RLuders.CORS

**This API is based on the first version of this plugin https://github.com/SaifurRahmanMohsin/oc-rest-plugin**


<a name="overview"></a>
# API Overview

### Shop

- [ ] `GET /api/settings`
- [ ] `GET /api/shippings`
- [ ] `GET /api/payments`
- [ ] `GET /api/properties`
- [x] `GET /api/categories`
- [x] `GET /api/categories/{slug*}` or `GET /api/categories/{id}`
- [x] `GET /api/categories/{slug*}?gender=female` or `GET /api/categories/{id}?gender=female`
- [x] `GET /api/brands`
- [x] `GET /api/brands/{slug*}` or `GET /api/brands/{id}`
- [x] `GET /api/products`
- [x] `GET /api/products?sort=latest` >> default
- [x] `GET /api/products?on_sale=true`
- [x] `GET /api/products?brand=cruiser-bikes`
- [x] `GET /api/products?brand=cruiser-bikes&on_sale=true&sort=latest`
- [x] `GET /api/products?sort=oldest`
- [x] `GET /api/products?sort=bestseller`
- [x] `GET /api/products?sort=ratings`
- [x] `GET /api/products?sort=price`
- [x] `GET /api/products?sort=price_high`
- [x] `GET /api/products?sort=price_low`
- [x] `GET /api/products?sort=name_asc`
- [x] `GET /api/products?sort=name_desc`
- [x] `GET /api/products/{id}`
- [x] `GET /api/products/{categorySlug*}` (Ex: /api/products/bikes or /api/products/bikes/citybikes)
- [ ] `GET /api/products/{id}/review`


### Customers

- [x] `POST /api/auth/register`
- [x] `POST /api/auth/account-activation`
- [x] `POST /api/auth/forgot-password`
- [x] `POST /api/auth/reset-password`
- [x] `POST /api/auth/refresh-token`
- [x] `POST /api/auth/login`
- [x] `GET /api/auth/me`
- [ ] `GET /api/auth/me/customer`
- [ ] `PUT /api/auth/me/customer`
- [ ] `GET /api/auth/me/addresses`
- [ ] `GET /api/auth/me/addresses/{id}`
- [ ] `POST /api/auth/me/addresses`
- [ ] `PUT /api/auth/me/addresses/{id}`
- [ ] `DELETE /api/auth/me/addresses/{id}`
- [ ] `GET /api/auth/me/orders`
- [ ] `GET /api/auth/me/orders/{id}`
- [ ] `GET /api/auth/me/wishlist`
- [ ] `DELETE /api/auth/me/wishlist/{id}`


### Cart &amp; Checkout process

- [ ] `GET /api/cart`
- [ ] `POST /api/cart`
- [ ] `PUT /api/cart/{cartItemId}`
- [ ] `DELETE /api/cart/{cartItemId}`
- [ ] `POST /api/checkout`
