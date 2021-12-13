import {Component, OnInit} from '@angular/core';
import {Navigator} from '../../utils/navigator';
import {SwiperConfigInterface} from 'ngx-swiper-wrapper';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {
  public teachers = [
    {name: '김지현', school: '서울대학교', major: '수학교육과'},
    {name: '정용준', school: '서울대학교', major: '수학교육과'},
    {name: '정도현', school: '포항공과대학교', major: '융합생명공학부'},
    {name: '이찬희', school: '서울대학교', major: '수학교육과'},
    {name: '박정기', school: '포항공과대학교', major: '전자전기공학과'}
  ]
  public config: SwiperConfigInterface = {};
  constructor(
    public navigator: Navigator
  ) {}

  ngOnInit(): void {
  }
}
