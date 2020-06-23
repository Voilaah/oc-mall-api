# RESTFUL API for October CMS OFFLINE MALL plugin


Plugins Required:
- RainLab.User
- OFFLINE.Mall
- OFFLINE.SiteSearch
- RLuders.JWTAuth
- RLuders.CORS

**Based on https://github.com/SaifurRahmanMohsin/oc-rest-plugin**


<a name="overview"></a>
# API Overview

### Shop

`GET /api/settings`

`GET /api/shippings`

`GET /api/payments`

`GET /api/categories`

`GET /api/categories/{slug*}` or `GET /api/categories/{id}`

`GET /api/brands`

`GET /api/brands/{slug*}` or `GET /api/brands/{id}`

`GET /api/products`

`GET /api/products/{slug*}` or `GET /api/products/{id}`

`POST /api/products/{slug*}/review` or `GET /api/products/{id}/review`


### Customers

`POST /api/auth/register`

`POST /api/auth/account-activation`

`POST /api/auth/forgot-password`

`POST /api/auth/reset-password`

`POST /api/auth/refresh-token`

`POST /api/auth/login`

`GET /api/auth/me`

`GET /api/auth/me/customer`

`PUT /api/auth/me/customer`

`GET /api/auth/me/addresses`

`GET /api/auth/me/addresses/{id}`

`POST /api/auth/me/addresses`

`PUT /api/auth/me/addresses/{id}`

`DELETE /api/auth/me/addresses/{id}`

`GET /api/auth/me/orders`

`GET /api/auth/me/orders/{id}`

`GET /api/auth/me/wishlist`

`DELETE /api/auth/me/wishlist/{id}`


### Checkout process

`GET /api/cart`

`POST /api/cart`

`PUT /api/cart/{cartItemId}`

`POST /api/checkout`
