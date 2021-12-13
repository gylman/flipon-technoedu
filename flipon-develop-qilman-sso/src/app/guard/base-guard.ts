import {Injectable} from '@angular/core';
import {ActivatedRouteSnapshot, CanActivate, Router, RouterStateSnapshot, UrlTree} from '@angular/router';
import {MeService} from '../service/me.service';
import {Observable, of} from 'rxjs';
import {catchError, map} from 'rxjs/operators';
import {UserModel} from '../models/user.model';

@Injectable()
export class BaseGuard implements CanActivate {
  constructor(
    public meService: MeService,
    public router: Router
  ) {
  }

  signIn(state: RouterStateSnapshot): UrlTree {
    return this.router.parseUrl('auth/signin?r=' + state.url);
  }

  home(): UrlTree {
    return this.router.parseUrl('');
  }

  getMe(): Observable<UserModel | null> {
    if (this.meService.me) {
      return of(this.meService.me);
    }

    return this.meService
      .getMe()
      .pipe(catchError(err => of(null)));
  }

  canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<true | UrlTree> {
    return this.getMe()
      .pipe(map((user: UserModel | null) => user ? true : this.signIn(state)));
  }
}
