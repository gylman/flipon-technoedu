import {NgModule} from '@angular/core';
import {SwiperModule, SWIPER_CONFIG, SwiperConfigInterface} from 'ngx-swiper-wrapper';
import {SharedModule} from '../../shared/shared.module';

import {HomeRoutingModule} from './home-routing.module';
import {HomeComponent} from './home.component';

const DEFAULT_SWIPER_CONFIG: SwiperConfigInterface = {
  direction: 'horizontal',
  slidesPerView: 1,
  a11y: true,
  slideToClickedSlide: true,
  mousewheel: false,
  scrollbar: false,
  watchSlidesProgress: true,
  navigation: true,
  keyboard: true,
  pagination: false,
  centeredSlides: false,
  loop: false,
  roundLengths: true,
  slidesOffsetBefore: 5,
  slidesOffsetAfter: 5,
  spaceBetween: 0,
  breakpoints: {
    // when window width is >= 320px
    1000: {
      slidesPerView: 3
    },
    700: {
      slidesPerView: 2
    }
  }
};

@NgModule({
  declarations: [HomeComponent],
  imports: [
    HomeRoutingModule,
    SwiperModule,
    SharedModule
  ],
  providers: [
    {
      provide: SWIPER_CONFIG,
      useValue: DEFAULT_SWIPER_CONFIG
    }
  ]
})
export class HomeModule {}
