import {Inject, Injectable, PLATFORM_ID} from '@angular/core';
import {Api} from '../utils/api';
import {Observable} from 'rxjs';
import {UserModel} from '../models/user.model';
import {map} from 'rxjs/operators';
import {CourseModel} from '../models/course.model';
import {isPlatformBrowser} from '@angular/common';

@Injectable({
  providedIn: 'root'
})
export class MeService {
  constructor(
    @Inject(PLATFORM_ID) private platformId: object,
    private api: Api
  ) {
  }

  me: UserModel | null = null;

  getMeSilently(): void {
    this.getMe()
      .subscribe(
        user => {
          if (isPlatformBrowser(this.platformId)) {
            document.cookie = document.cookie + '; domain=*.flip-on.com; Max-Age=0;';
            document.cookie = '_fui=' + JSON.stringify({id: user.id}) + '; domain=flip-on.com;';
          }
        },
        _ => {}
      );
  }

  getMe(): Observable<UserModel> {
    return this.api
      .request('/me', 'GET')
      .pipe(map(x => {
        this.me = new UserModel(x);
        return this.me;
      }));
  }

  getCourses(): Observable<Array<CourseModel>> {
    return this.api
      .request('/me/courses', 'GET')
      .pipe(map((x: {count: number, items: Array<any>}) => {
        return x.items.map(v => new CourseModel(v));
      }));
  }

  requestCourse(teacher: string): Observable<CourseModel> {
    return this.api
      .request('/me/courses', 'POST', {teacher})
      .pipe(map(x => new CourseModel(x)));
  }
}
