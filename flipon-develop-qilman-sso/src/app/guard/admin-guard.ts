import {Injectable} from '@angular/core';
import {ActivatedRouteSnapshot, Router, RouterStateSnapshot, UrlTree} from '@angular/router';
import {MeService} from '../service/me.service';
import {BaseGuard} from './base-guard';
import {map} from 'rxjs/operators';
import {Observable} from 'rxjs';
import {UserModel} from '../models/user.model';

@Injectable()
export class AdminGuard extends BaseGuard {
  constructor(
   public meService: MeService,
   public router: Router
  ) {
    super(meService, router);
  }

  canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<true | UrlTree> {
    return this.getMe()
      .pipe(map((user: UserModel | null) => user ? user.isAdmin() ? true : this.home() : this.signIn(state)));
  }
}
