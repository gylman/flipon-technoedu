import {Component, Inject, OnInit, PLATFORM_ID} from '@angular/core';
import {Navigator} from './utils/navigator';
import {isPlatformBrowser} from '@angular/common';
import {filter} from 'rxjs/operators';
import {NavigationStart} from '@angular/router';
import {MeService} from './service/me.service';
import {environment} from '../environments/environment';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnInit {
  title = 'flipon';
  expanded = false;

  constructor(
    @Inject(PLATFORM_ID) private platformId: object,
    public navigator: Navigator,
    public meService: MeService
  ) {
    navigator.router.events.pipe(
      filter(event => event instanceof NavigationStart),
    ).subscribe((event: NavigationStart) => {
      this.expanded = false;
      this.meService.getMeSilently();
    });
  }

  ngOnInit() {
    this.meService.getMeSilently();
  }

  signOut() {
    if (isPlatformBrowser(this.platformId)) {
      localStorage.setItem('token', '');
      this.meService.me = null;
      // this.navigator.home();

      // Redirect to TechnoEdu to log out
      const r = '';
      window.location.href = environment.technoeduLogoutRedirUrl + `?r=${r}`;
    }
  }

  get isExtern(): boolean {
    if (isPlatformBrowser(this.platformId)) {
      const w = window as any;
      if (w.WSMEDIA) {
        return true;
      }
    }
    return false;
  }

  changeExpanded(): void {
    this.expanded = !this.expanded;
  }
}
