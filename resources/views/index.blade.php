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

        

  </main>
@endsection