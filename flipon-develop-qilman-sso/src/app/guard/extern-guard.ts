import {Inject, Injectable, PLATFORM_ID} from '@angular/core';
import {ActivatedRouteSnapshot, CanActivate, RouterStateSnapshot} from '@angular/router';
import {Navigator} from '../utils/navigator';
import {isPlatformBrowser} from '@angular/common';

@Injectable()
export class ExternGuard implements CanActivate {
  constructor(
    @Inject(PLATFORM_ID) private platformId: object,
    public navigator: Navigator
  ) {
  }

  canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): boolean {
    if (!isPlatformBrowser(this.platformId)) { return true; }

    const w = window as any;
    if (w.WSMEDIA) {
      this.navigator.externMentorBox();
      return false;
    }

    return true;
  }
}
