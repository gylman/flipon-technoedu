import {Api} from '../utils/api';
import {Injectable} from '@angular/core';
import {Observable} from 'rxjs';
import {UserModel} from '../models/user.model';
import {map} from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class UserService {
  constructor(
    private api: Api
  ) {
  }

  getUserById(id: string): Observable<UserModel> {
    return this.api
      .request('/users/' + id, 'GET')
      .pipe(map(x => new UserModel(x)));
  }

  getUsers(conditions: any = {}): Observable<{count: number, items: Array<UserModel>}> {
    return this.api
      .request('/users', 'GET', conditions)
      .pipe(map((x: {count: number, items: Array<any>}) => {
        return {count: x.count, items: x.items.map(v => new UserModel(v))};
      }));
  }

  getTeachers(subject: string): Observable<{count: number, items: Array<UserModel>}> {
    return this.api
      .request('/teachers', 'GET', {profile: {subject}})
      .pipe(map((x: {count: number, items: Array<any>}) => {
        return {count: x.count, items: x.items.map(v => new UserModel(v))};
      }));
  }

  approveTeacher(id: string): Observable<any> {
    return this.api
      .request('/users/' + id, 'PUT', {status: {isAccepted: true}});
  }
}
