@extends('layouts.app')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Clicker+Script&family=Hind+Siliguri:wght@300;400;500;600;700&family=MonteCarlo&family=Passions+Conflict&display=swap" rel="stylesheet">
<main>

    <section class="swiper-container js-swiper-slider swiper-number-pagination slideshow" data-settings='{
        "autoplay": {
          "delay": 5000
        },
        "slidesPerView": 1,
        "effect": "fade",
        "loop": true
      }'>
      <div class="swiper-wrapper">
        <div class="swiper-slide">
          <div class="overflow-hidden position-relative h-100">
            <div class="slideshow-character position-absolute bottom-0 pos_right-center">
              <img loading="lazy"  src=" {{asset('assets/images/home/demo3/slideshow-character1.png')}}" width="542" height="733"
                alt="Woman Fashion 1"
                class="slideshow-character__img animate animate_fade animate_btt animate_delay-9 w-auto h-auto" />
              <div class="character_markup type2">
                <p
                  class="text-uppercase font-sofia mark-grey-color animate animate_fade animate_btt animate_delay-10 mb-0">
                  Beauty</p>
              </div>
            </div>
            <div class="slideshow-text container position-absolute start-50 top-50 translate-middle">
              <h6 class="clicker-script-regular text_dash text-uppercase fs-base fw-medium animate animate_fade animate_btt animate_delay-3">
                best place for you</h6>
              <h2 class="h1 fw-normal mb-0 animate animate_fade animate_btt animate_delay-5">Glow Up</h2>
              <h2 class="h1 fw-bold animate animate_fade animate_btt animate_delay-5">Starts Here</h2>
              <a href="{{ route('shop.index') }}" 
                class="btn-link btn-link_lg default-underline fw-medium animate animate_fade animate_btt animate_delay-7">Shop
                Now</a>
            </div>
          </div>
        </div>

        <div class="swiper-slide">
          <div class="overflow-hidden position-relative h-100">
            <div class="slideshow-character position-absolute bottom-0 pos_right-center">
              <img loading="lazy"  src=" {{asset('assets/images/slideshow-character1.png')}}" width="400" height="733"
                alt="Woman Fashion 1"
                class="slideshow-character__img animate animate_fade animate_btt animate_delay-9 w-auto h-auto" />
              <div class="character_markup">
                <p class="text-uppercase font-sofia fw-bold animate animate_fade animate_rtl animate_delay-10">Summer
                </p>
              </div>
            </div>
            <div class="slideshow-text container position-absolute start-50 top-50 translate-middle">
              <h6 class="clicker-script-regular text_dash text-uppercase fs-base fw-medium animate animate_fade animate_btt animate_delay-3">
                best place for you</h6>
              <h2 class="h1 fw-normal mb-0 animate animate_fade animate_btt animate_delay-5">Pamper Yourself,</h2>
              <h2 class="h1 fw-bold animate animate_fade animate_btt animate_delay-5">You Deserve It</h2>
              <a href="{{ route('shop.index') }}" 
                class="btn-link btn-link_lg default-underline fw-medium animate animate_fade animate_btt animate_delay-7">Shop
                Now</a>
            </div>
          </div>
        </div>

        <div class="swiper-slide">
          <div class="overflow-hidden position-relative h-100">
            <div class="slideshow-character position-absolute bottom-0 pos_right-center">
              <img loading="lazy"  src=" {{asset('assets/images/slideshow-character2.png')}}" width="400" height="690"
                alt="Woman Fashion 2"
                class="slideshow-character__img animate animate_fade animate_rtl animate_delay-10 w-auto h-auto" />
            </div>
            <div class="slideshow-text container position-absolute start-50 top-50 translate-middle">
              <h6 class="clicker-script-regular text_dash text-uppercase fs-base fw-medium animate animate_fade animate_btt animate_delay-3">
                best place for you</h6>
              <h2 class="h1 fw-normal mb-0 animate animate_fade animate_btt animate_delay-5">From Skincare</h2>
              <h2 class="h1 fw-bold animate animate_fade animate_btt animate_delay-5">to Self-Care</h2>
              <a href="{{ route('shop.index') }}" 
                class="btn-link btn-link_lg default-underline fw-medium animate animate_fade animate_btt animate_delay-7">Shop
                Now</a>
            </div>
          </div>
        </div>
      </div>

      <div class="container">
        <div
          class="slideshow-pagination slideshow-number-pagination d-flex align-items-center position-absolute bottom-0 mb-5">
        </div>
      </div>
    </section>
    <div class="container mw-1620 bg-white border-radius-10">
      <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>
      <section class="category-carousel container">
        <h2 class="section-title text-center mb-3 pb-xl-2 mb-xl-4">Categories</h2>

        <div class="position-relative">
          <div class="swiper-container js-swiper-slider" data-settings='{
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": 8,
              "slidesPerGroup": 1,
              "effect": "none",
              "loop": true,
              "navigation": {
                "nextEl": ".products-carousel__next-1",
                "prevEl": ".products-carousel__prev-1"
              },
              "breakpoints": {
                "320": {
                  "slidesPerView": 2,
                  "slidesPerGroup": 2,
                  "spaceBetween": 15
                },
                "768": {
                  "slidesPerView": 4,
                  "slidesPerGroup": 4,
                  "spaceBetween": 30
                },
                "992": {
                  "slidesPerView": 6,
                  "slidesPerGroup": 1,
                  "spaceBetween": 45,
                  "pagination": false
                },
                "1200": {
                  "slidesPerView": 8,
                  "slidesPerGroup": 1,
                  "spaceBetween": 60,
                  "pagination": false
                }
              }
            }'>
            <div class="swiper-wrapper">
              <div class="swiper-slide">
                <img loading="lazy" class="w-100 h-auto mb-3"  src=" {{asset('assets/images/home/demo3/category_skincare.png')}}" width="124"
                  height="124" alt="" />
                <div class="text-center">
                  <a href="{{ route('shop.index') }}" class="menu-link fw-medium">Skincare</a>
                </div>
              </div>
              <div class="swiper-slide">
                <img loading="lazy" class="w-100 h-auto mb-3"  src=" {{asset('assets/images/home/demo3/category_soap.png')}}" width="124"
                  height="124" alt="" />
                <div class="text-center">
                  <a href="{{ route('shop.index') }}" class="menu-link fw-medium">Soap</a>
                </div>
              </div>
              <div class="swiper-slide">
                <img loading="lazy" class="w-100 h-auto mb-3"  src=" {{asset('assets/images/home/demo3/category_sampo.png')}}" width="124"
                  height="124" alt="" />
                <div class="text-center">
                  <a href="{{ route('shop.index') }}" class="menu-link fw-medium">Shampoo</a>
                </div>
              </div>
              <div class="swiper-slide">
                <img loading="lazy" class="w-100 h-auto mb-3"  src=" {{asset('assets/images/home/demo3/category_bodycare.png')}}" width="124"
                  height="124" alt="" />
                <div class="text-center">
                  <a href="{{ route('shop.index') }}" class="menu-link fw-medium">Body Care</a>
                </div>
              </div>
              <div class="swiper-slide">
                <img loading="lazy" class="w-100 h-auto mb-3"  src=" {{asset('assets/images/home/demo3/category_makeup.png')}}" width="124"
                  height="124" alt="" />
                <div class="text-center">
                  <a href="{{ route('shop.index') }}" class="menu-link fw-medium">Face Makeup</a>
                </div>
              </div>
              <div class="swiper-slide">
                <img loading="lazy" class="w-100 h-auto mb-3"  src=" {{asset('assets/images/home/demo3/category_parfume.png')}}" width="124"
                  height="124" alt="" />
                <div class="text-center">
                  <a href="{{ route('shop.index') }}" class="menu-link fw-medium">Parfume</a>
                </div>
              </div>
              <div class="swiper-slide">
                <img loading="lazy" class="w-100 h-auto mb-3"  src=" {{asset('assets/images/home/demo3/category_makeuptools.png')}}" width="124"
                  height="124" alt="" />
                <div class="text-center">
                  <a href="{{ route('shop.index') }}" class="menu-link fw-medium">Cosmetic Tools</a>
                </div>
              </div>
              <div class="swiper-slide">
                <img loading="lazy" class="w-100 h-auto mb-3"  src=" {{asset('assets/images/home/demo3/category_bath.png')}}" width="124"
                  height="124" alt="" />
                <div class="text-center">
                  <a href="{{ route('shop.index') }}" class="menu-link fw-medium">Bathing Tools</a>
                </div>
              </div>
          
              </div>
            </div><!-- /.swiper-wrapper -->
          </div><!-- /.swiper-container js-swiper-slider -->
      </section>

      <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

      <section class="hot-deals container">
        <h2 class="section-title text-center mb-3 pb-xl-3 mb-xl-4">Most Popular Products</h2>
        <div class="row">
          <div
            class="col-md-6 col-lg-4 col-xl-20per d-flex align-items-center flex-column justify-content-center py-4 align-items-md-start">
            <div class="h2-yay"><h2 style="font-size: 24px;">Most Frequently</h2>
              <h2 style="font-size: 24px;">Purchased Items</h2></div>

            <div class="position-relative d-flex align-items-center text-center pt-xxl-4 js-countdown mb-3"
              data-date="18-3-2024" data-time="06:50">
              <div class="day countdown-unit">
                <span class="countdown-num d-block"></span>
                <span class="countdown-word text-uppercase text-secondary">Days</span>
              </div>

              <div class="hour countdown-unit">
                <span class="countdown-num d-block"></span>
                <span class="countdown-word text-uppercase text-secondary">Hours</span>
              </div>

              <div class="min countdown-unit">
                <span class="countdown-num d-block"></span>
                <span class="countdown-word text-uppercase text-secondary">Mins</span>
              </div>

              <div class="sec countdown-unit">
                <span class="countdown-num d-block"></span>
                <span class="countdown-word text-uppercase text-secondary">Sec</span>
              </div>
            </div>

            <a href="#" class="btn-link default-underline text-uppercase fw-medium mt-3">View All</a>
          </div>
          <div class="col-md-6 col-lg-8 col-xl-80per">
            <div class="position-relative">
              <div class="swiper-container js-swiper-slider" data-settings='{
                  "autoplay": {
                    "delay": 5000
                  },
                  "slidesPerView": 4,
                  "slidesPerGroup": 4,
                  "effect": "none",
                  "loop": false,
                  "breakpoints": {
                    "320": {
                      "slidesPerView": 2,
                      "slidesPerGroup": 2,
                      "spaceBetween": 14
                    },
                    "768": {
                      "slidesPerView": 2,
                      "slidesPerGroup": 3,
                      "spaceBetween": 24
                    },
                    "992": {
                      "slidesPerView": 3,
                      "slidesPerGroup": 1,
                      "spaceBetween": 30,
                      "pagination": false
                    },
                    "1200": {
                      "slidesPerView": 4,
                      "slidesPerGroup": 1,
                      "spaceBetween": 30,
                      "pagination": false
                    }
                  }
                }'>
                <div class="swiper-wrapper">
                  <div class="swiper-slide product-card product-card_style3">
                    <div class="pc__img-wrapper">
                      <a href="details.html">
                        <img loading="lazy"  src=" {{asset('assets/images/home/demo3/product-0-1.jpg')}}" width="258" height="313"
                          alt="Cropped Faux leather Jacket" class="pc__img">
                        <img loading="lazy"  src=" {{asset('assets/images/home/demo3/product-0-2.jpg')}}" width="258" height="313"
                          alt="Cropped Faux leather Jacket" class="pc__img pc__img-second">
                      </a>
                    </div>

                    <div class="pc__info position-relative">
                      <h6 class="pc__title"><a href="details.html">Cropped Faux Leather Jacket</a></h6>
                      <div class="product-card__price d-flex">
                        <span class="money price text-secondary">$29</span>
                      </div>

                      <div
                        class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                        <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                          data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                        <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                          data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                          <span class="d-none d-xxl-block">Quick View</span>
                          <span class="d-block d-xxl-none"><svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                              xmlns="http://www.w3.org/2000/svg">
                              <use href="#icon_view" />
                            </svg></span>
                        </button>
                        <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist" title="Add To Wishlist">
                          <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_heart" />
                          </svg>
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-slide product-card product-card_style3">
                    <div class="pc__img-wrapper">
                      <a href="details.html">
                        <img loading="lazy"  src=" {{asset('assets/images/home/demo3/product-1-1.jpg')}}" width="258" height="313"
                          alt="Cropped Faux leather Jacket" class="pc__img">
                        <img loading="lazy"  src=" {{asset('assets/images/home/demo3/product-1-2.jpg')}}" width="258" height="313"
                          alt="Cropped Faux leather Jacket" class="pc__img pc__img-second">
                      </a>
                    </div>

                    <div class="pc__info position-relative">
                      <h6 class="pc__title"><a href="details.html">Calvin Shorts</a></h6>
                      <div class="product-card__price d-flex">
                        <span class="money price text-secondary"></span>
                      </div>

                      <div
                        class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                        <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                          data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                        <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                          data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                          <span class="d-none d-xxl-block">Quick View</span>
                          <span class="d-block d-xxl-none"><svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                              xmlns="http://www.w3.org/2000/svg">
                              <use href="#icon_view" />
                            </svg></span>
                        </button>
                        <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist" title="Add To Wishlist">
                          <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_heart" />
                          </svg>
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-slide product-card product-card_style3">
                    <div class="pc__img-wrapper">
                      <a href="details.html">
                        <img loading="lazy"  src=" {{asset('assets/images/home/demo3/product-2-1.jpg')}}" width="258" height="313"
                          alt="Cropped Faux leather Jacket" class="pc__img">
                        <img loading="lazy"  src=" {{asset('assets/images/home/demo3/product-2-2.jpg')}}" width="258" height="313"
                          alt="Cropped Faux leather Jacket" class="pc__img pc__img-second">
                      </a>
                    </div>

                    <div class="pc__info position-relative">
                      <h6 class="pc__title"><a href="details.html">Kirby T-Shirt</a></h6>
                      <div class="product-card__price d-flex">
                        <span class="money price text-secondary">$62</span>
                      </div>

                      <div
                        class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                        <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                          data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                        <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                          data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                          <span class="d-none d-xxl-block">Quick View</span>
                          <span class="d-block d-xxl-none"><svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                              xmlns="http://www.w3.org/2000/svg">
                              <use href="#icon_view" />
                            </svg></span>
                        </button>
                        <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist" title="Add To Wishlist">
                          <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_heart" />
                          </svg>
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-slide product-card product-card_style3">
                    <div class="pc__img-wrapper">
                      <a href="details.html">
                        <img loading="lazy"  src=" {{asset('assets/images/home/demo3/product-3-1.jpg')}}" width="258" height="313"
                          alt="Cropped Faux leather Jacket" class="pc__img">
                        <img loading="lazy"  src=" {{asset('assets/images/home/demo3/product-3-2.jpg')}}" width="258" height="313"
                          alt="Cropped Faux leather Jacket" class="pc__img pc__img-second">
                      </a>
                    </div>

                    <div class="pc__info position-relative">
                      <h6 class="pc__title"><a href="details.html">Cableknit Shawl</a></h6>
                      <div class="product-card__price d-flex align-items-center">
                        <span class="money price-old">$129</span>
                        <span class="money price text-secondary">$99</span>
                      </div>

                      <div
                        class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                        <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                          data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                        <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                          data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                          <span class="d-none d-xxl-block">Quick View</span>
                          <span class="d-block d-xxl-none"><svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                              xmlns="http://www.w3.org/2000/svg">
                              <use href="#icon_view" />
                            </svg></span>
                        </button>
                        <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist" title="Add To Wishlist">
                          <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_heart" />
                          </svg>
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-slide product-card product-card_style3">
                    <div class="pc__img-wrapper">
                      <a href="details.html">
                        <img loading="lazy"  src=" {{asset('assets/images/home/demo3/product-0-1.jpg')}}" width="258" height="313"
                          alt="Cropped Faux leather Jacket" class="pc__img">
                        <img loading="lazy"  src=" {{asset('assets/images/home/demo3/product-0-2.jpg')}}" width="258" height="313"
                          alt="Cropped Faux leather Jacket" class="pc__img pc__img-second">
                      </a>
                    </div>

                    <div class="pc__info position-relative">
                      <h6 class="pc__title"><a href="details.html">Cropped Faux Leather Jacket</a></h6>
                      <div class="product-card__price d-flex">
                        <span class="money price text-secondary">$29</span>
                      </div>

                      <div
                        class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                        <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                          data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                        <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                          data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                          <span class="d-none d-xxl-block">Quick View</span>
                          <span class="d-block d-xxl-none"><svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                              xmlns="http://www.w3.org/2000/svg">
                              <use href="#icon_view" />
                            </svg></span>
                        </button>
                        <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist" title="Add To Wishlist">
                          <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_heart" />
                          </svg>
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-slide product-card product-card_style3">
                    <div class="pc__img-wrapper">
                      <a href="details.html">
                        <img loading="lazy"  src=" {{asset('assets/images/home/demo3/product-1-1.jpg')}}" width="258" height="313"
                          alt="Cropped Faux leather Jacket" class="pc__img">
                        <img loading="lazy"  src=" {{asset('assets/images/home/demo3/product-1-2.jpg')}}" width="258" height="313"
                          alt="Cropped Faux leather Jacket" class="pc__img pc__img-second">
                      </a>
                    </div>

                    <div class="pc__info position-relative">
                      <h6 class="pc__title"><a href="details.html">Calvin Shorts</a></h6>
                      <div class="product-card__price d-flex">
                        <span class="money price text-secondary">$62</span>
                      </div>

                      <div
                        class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                        <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                          data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                        <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                          data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                          <span class="d-none d-xxl-block">Quick View</span>
                          <span class="d-block d-xxl-none"><svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                              xmlns="http://www.w3.org/2000/svg">
                              <use href="#icon_view" />
                            </svg></span>
                        </button>
                        <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist" title="Add To Wishlist">
                          <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_heart" />
                          </svg>
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-slide product-card product-card_style3">
                    <div class="pc__img-wrapper">
                      <a href="details.html">
                        <img loading="lazy"  src=" {{asset('assets/images/home/demo3/product-2-1.jpg')}}" width="258" height="313"
                          alt="Cropped Faux leather Jacket" class="pc__img">
                        <img loading="lazy"  src=" {{asset('assets/images/home/demo3/product-2-2.jpg')}}" width="258" height="313"
                          alt="Cropped Faux leather Jacket" class="pc__img pc__img-second">
                      </a>
                    </div>

                    <div class="pc__info position-relative">
                      <h6 class="pc__title"><a href="details.html">Kirby T-Shirt</a></h6>
                      <div class="product-card__price d-flex">
                        <span class="money price text-secondary">$62</span>
                      </div>

                      <div
                        class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                        <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                          data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                        <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                          data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                          <span class="d-none d-xxl-block">Quick View</span>
                          <span class="d-block d-xxl-none"><svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                              xmlns="http://www.w3.org/2000/svg">
                              <use href="#icon_view" />
                            </svg></span>
                        </button>
                        <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist" title="Add To Wishlist">
                          <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_heart" />
                          </svg>
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-slide product-card product-card_style3">
                    <div class="pc__img-wrapper">
                      <a href="details.html">
                        <img loading="lazy"  src=" {{asset('assets/images/home/demo3/product-3-1.jpg')}}" width="258" height="313"
                          alt="Cropped Faux leather Jacket" class="pc__img">
                        <img loading="lazy"  src=" {{asset('assets/images/home/demo3/product-3-2.jpg')}}" width="258" height="313"
                          alt="Cropped Faux leather Jacket" class="pc__img pc__img-second">
                      </a>
                    </div>

                    <div class="pc__info position-relative">
                      <h6 class="pc__title"><a href="details.html">Cableknit Shawl</a></h6>
                      <div class="product-card__price d-flex align-items-center">
                        <span class="money price-old">$129</span>
                        <span class="money price text-secondary">$99</span>
                      </div>

                      <div
                        class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                        <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                          data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                        <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                          data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                          <span class="d-none d-xxl-block">Quick View</span>
                          <span class="d-block d-xxl-none"><svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                              xmlns="http://www.w3.org/2000/svg">
                              <use href="#icon_view" />
                            </svg></span>
                        </button>
                        <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist" title="Add To Wishlist">
                          <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_heart" />
                          </svg>
                        </button>
                      </div>
                    </div>
                  </div>
                </div><!-- /.swiper-wrapper -->
              </div><!-- /.swiper-container js-swiper-slider -->
            </div><!-- /.position-relative -->
          </div>
        </div>
      </section>

      <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

      <section class="products-grid container">
        <h2 class="section-title text-center mb-3 pb-xl-3 mb-xl-4">Featured Products</h2>

        <div class="row">
          <div class="col-6 col-md-4 col-lg-3">
            <div class="product-card product-card_style3 mb-3 mb-md-4 mb-xxl-5">
              <div class="pc__img-wrapper">
                <a href="details.html">
                  <img loading="lazy"  src=" {{asset('assets/images/home/demo3/product-4.jpg')}}" width="330" height="400"
                    alt="Cropped Faux leather Jacket" class="pc__img">
                </a>
              </div>

              <div class="pc__info position-relative">
                <h6 class="pc__title"><a href="details.html">Cropped Faux Leather Jacket</a></h6>
                <div class="product-card__price d-flex align-items-center">
                  <span class="money price text-secondary">$29</span>
                </div>

                <div
                  class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                  <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                    data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                  <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                    data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                    <span class="d-none d-xxl-block">Quick View</span>
                    <span class="d-block d-xxl-none"><svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_view" />
                      </svg></span>
                  </button>
                  <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist" title="Add To Wishlist">
                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <use href="#icon_heart" />
                    </svg>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div class="col-6 col-md-4 col-lg-3">
            <div class="product-card product-card_style3 mb-3 mb-md-4 mb-xxl-5">
              <div class="pc__img-wrapper">
                <a href="details.html">
                  <img loading="lazy"  src=" {{asset('assets/images/home/demo3/product-5.jpg')}}" width="330" height="400"
                    alt="Cropped Faux leather Jacket" class="pc__img">
                </a>
              </div>

              <div class="pc__info position-relative">
                <h6 class="pc__title"><a href="details.html">Calvin Shorts</a></h6>
                <div class="product-card__price d-flex align-items-center">
                  <span class="money price text-secondary">$62</span>
                </div>

                <div
                  class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                  <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                    data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                  <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                    data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                    <span class="d-none d-xxl-block">Quick View</span>
                    <span class="d-block d-xxl-none"><svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_view" />
                      </svg></span>
                  </button>
                  <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist" title="Add To Wishlist">
                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <use href="#icon_heart" />
                    </svg>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div class="col-6 col-md-4 col-lg-3">
            <div class="product-card product-card_style3 mb-3 mb-md-4 mb-xxl-5">
              <div class="pc__img-wrapper">
                <a href="details.html">
                  <img loading="lazy"  src=" {{asset('assets/images/home/demo3/product-6.jpg')}}" width="330" height="400"
                    alt="Cropped Faux leather Jacket" class="pc__img">
                </a>
                <div class="product-label text-uppercase bg-white top-0 left-0 mt-2 mx-2">New</div>
              </div>

              <div class="pc__info position-relative">
                <h6 class="pc__title"><a href="details.html">Kirby T-Shirt</a></h6>
                <div class="product-card__price d-flex align-items-center">
                  <span class="money price text-secondary">$17</span>
                </div>

                <div
                  class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                  <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                    data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                  <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                    data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                    <span class="d-none d-xxl-block">Quick View</span>
                    <span class="d-block d-xxl-none"><svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_view" />
                      </svg></span>
                  </button>
                  <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist" title="Add To Wishlist">
                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <use href="#icon_heart" />
                    </svg>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div class="col-6 col-md-4 col-lg-3">
            <div class="product-card product-card_style3 mb-3 mb-md-4 mb-xxl-5">
              <div class="pc__img-wrapper">
                <a href="details.html">
                  <img loading="lazy"  src=" {{asset('assets/images/home/demo3/product-7.jpg')}}" width="330" height="400"
                    alt="Cropped Faux leather Jacket" class="pc__img">
                </a>
                <div class="product-label bg-red text-white right-0 top-0 left-auto mt-2 mx-2">-67%</div>
              </div>

              <div class="pc__info position-relative">
                <h6 class="pc__title">Cableknit Shawl</h6>
                <div class="product-card__price d-flex align-items-center">
                  <span class="money price-old">$129</span>
                  <span class="money price text-secondary">$99</span>
                </div>

                <div
                  class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                  <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                    data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                  <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                    data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                    <span class="d-none d-xxl-block">Quick View</span>
                    <span class="d-block d-xxl-none"><svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_view" />
                      </svg></span>
                  </button>
                  <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist" title="Add To Wishlist">
                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <use href="#icon_heart" />
                    </svg>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div class="col-6 col-md-4 col-lg-3">
            <div class="product-card product-card_style3 mb-3 mb-md-4 mb-xxl-5">
              <div class="pc__img-wrapper">
                <a href="details.html">
                  <img loading="lazy"  src=" {{asset('assets/images/home/demo3/product-8.jpg')}}" width="330" height="400"
                    alt="Cropped Faux leather Jacket" class="pc__img">
                </a>
              </div>

              <div class="pc__info position-relative">
                <h6 class="pc__title"><a href="details.html">Cropped Faux Leather Jacket</a></h6>
                <div class="product-card__price d-flex align-items-center">
                  <span class="money price text-secondary">$29</span>
                </div>

                <div
                  class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                  <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                    data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                  <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                    data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                    <span class="d-none d-xxl-block">Quick View</span>
                    <span class="d-block d-xxl-none"><svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_view" />
                      </svg></span>
                  </button>
                  <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist" title="Add To Wishlist">
                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <use href="#icon_heart" />
                    </svg>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div class="col-6 col-md-4 col-lg-3">
            <div class="product-card product-card_style3 mb-3 mb-md-4 mb-xxl-5">
              <div class="pc__img-wrapper">
                <a href="details.html">
                  <img loading="lazy"  src=" {{asset('assets/images/home/demo3/product-9.jpg')}}" width="330" height="400"
                    alt="Cropped Faux leather Jacket" class="pc__img">
                </a>
              </div>

              <div class="pc__info position-relative">
                <h6 class="pc__title"><a href="details.html">Calvin Shorts</a></h6>
                <div class="product-card__price d-flex align-items-center">
                  <span class="money price text-secondary">$62</span>
                </div>

                <div
                  class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                  <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                    data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                  <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                    data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                    <span class="d-none d-xxl-block">Quick View</span>
                    <span class="d-block d-xxl-none"><svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_view" />
                      </svg></span>
                  </button>
                  <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist" title="Add To Wishlist">
                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <use href="#icon_heart" />
                    </svg>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div class="col-6 col-md-4 col-lg-3">
            <div class="product-card product-card_style3 mb-3 mb-md-4 mb-xxl-5">
              <div class="pc__img-wrapper">
                <a href="details.html">
                  <img loading="lazy"  src=" {{asset('assets/images/home/demo3/product-10.jpg')}}" width="330" height="400"
                    alt="Cropped Faux leather Jacket" class="pc__img">
                </a>
              </div>

              <div class="pc__info position-relative">
                <h6 class="pc__title"><a href="details.html">Kirby T-Shirt</a></h6>
                <div class="product-card__price d-flex align-items-center">
                  <span class="money price text-secondary">$17</span>
                </div>

                <div
                  class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                  <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                    data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                  <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                    data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                    <span class="d-none d-xxl-block">Quick View</span>
                    <span class="d-block d-xxl-none"><svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_view" />
                      </svg></span>
                  </button>
                  <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist" title="Add To Wishlist">
                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <use href="#icon_heart" />
                    </svg>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div class="col-6 col-md-4 col-lg-3">
            <div class="product-card product-card_style3 mb-3 mb-md-4 mb-xxl-5">
              <div class="pc__img-wrapper">
                <a href="details.html">
                  <img loading="lazy"  src=" {{asset('assets/images/home/demo3/product-11.jpg')}}" width="330" height="400"
                    alt="Cropped Faux leather Jacket" class="pc__img">'
                </a>
              </div>

              <div class="pc__info position-relative">
                <h6 class="pc__title">Cableknit Shawl</h6>
                <div class="product-card__price d-flex align-items-center">
                  <span class="money price-old">$129</span>
                  <span class="money price text-secondary">$99</span>
                </div>

                <div
                  class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                  <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                    data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                  <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                    data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                    <span class="d-none d-xxl-block">Quick View</span>
                    <span class="d-block d-xxl-none"><svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_view" />
                      </svg></span>
                  </button>
                  <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist" title="Add To Wishlist">
                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <use href="#icon_heart" />
                    </svg>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div><!-- /.row -->

        <div class="text-center mt-2">
          <a class="btn-link btn-link_lg default-underline text-uppercase fw-medium" href="#">Load More</a>
        </div>
      </section>
    </div>

    <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

  </main>
@endsection