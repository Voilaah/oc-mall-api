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
- [x] `GET /api/brands`
- [x] `GET /api/brands/{slug*}` or `GET /api/brands/{id}`
- [x] `GET /api/products`
- [x] `GET /api/products/{slug*}` or `GET /api/products/{id}`
- [ ] `POST /api/products/{slug*}/review` or `GET /api/products/{id}/review`


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
