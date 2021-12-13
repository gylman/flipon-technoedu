import {Api} from '../utils/api';
import {Injectable} from '@angular/core';
import {Observable} from 'rxjs';
import {map} from 'rxjs/operators';
import {CourseModel, CourseStatus} from '../models/course.model';
import {UserModel} from '../models/user.model';

@Injectable({
  providedIn: 'root'
})
export class CourseService {
  constructor(
    private api: Api
  ) {
  }

  getCourses(conditions: any = {}): Observable<{count: number, items: Array<CourseModel>}> {
    return this.api
      .request('/courses', 'GET', conditions)
      .pipe(map((x: {count: number, items: Array<any>}) => {
        return {count: x.count, items: x.items.map(v => new CourseModel(v))};
      }));
  }

  createCourse(info: any = {}) {
    return this.api
      .request('/courses', 'POST', info);
  }

  approveCourse(id: string, info: any = {}) {
    info.status = CourseStatus.Active;
    return this.api
      .request('/courses/' + id, 'PUT', info);
  }
}
