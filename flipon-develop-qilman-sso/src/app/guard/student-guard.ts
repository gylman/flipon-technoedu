import {Injectable} from '@angular/core';
import {BaseGuard} from './base-guard';
import {MeService} from '../service/me.service';
import {ActivatedRouteSnapshot, Router, RouterStateSnapshot, UrlTree} from '@angular/router';
import {Observable} from 'rxjs';
import {map} from 'rxjs/operators';
import {UserModel} from '../models/user.model';

@Injectable()
export class StudentGuard extends BaseGuard {
  constructor(
    public meService: MeService,
    public router: Router
  ) {
    super(meService, router);
  }

  canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<true | UrlTree> {
    return this.getMe()
      .pipe(map((user: UserModel | null) => user ? user.isStudent() ? true : this.home() : this.signIn(state)));
  }
}
