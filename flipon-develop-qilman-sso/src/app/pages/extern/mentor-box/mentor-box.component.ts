import {Component, Inject, OnInit, PLATFORM_ID} from '@angular/core';
import { CourseModel, CourseStatus } from '../../../models/course.model';
import { MeService } from '../../../service/me.service';
import { finalize, flatMap } from 'rxjs/operators';
import { RoomModel } from '../../../models/room.model';
import { Navigator } from '../../../utils/navigator';
import {isPlatformBrowser} from '@angular/common';

@Component({
  selector: 'app-mentor-box',
  templateUrl: './mentor-box.component.html',
  styleUrls: ['./mentor-box.component.scss']
})
export class MentorBoxComponent implements OnInit {
  courses: Array<CourseModel> = [];
  loading = true;

  constructor(
    @Inject(PLATFORM_ID) private platformId: object,
    public navigator: Navigator,
    public meService: MeService
  ) { }

  ngOnInit(): void {
    this.loading = true;
    this.meService
      .getMe()
      .pipe(flatMap(() => this.meService.getCourses()))
      .pipe(finalize(() => this.loading = false))
      .subscribe(
        value => {
          console.log(value);
          this.courses = value.filter(v => v.status === CourseStatus.Active);
        },
        error => { }
      );
  }

  get myName(): string {
    if (this.meService.me) {
      return this.meService.me.name;
    }
    return '';
  }

  enterRoom(room: RoomModel | null): void {
    if (!isPlatformBrowser(this.platformId)) { return; }
    if (!room) { return; }

    const no = `${0}${(380000 + room?.number)}`;
    const mode = this.meService.me?.isStudent() ? 1 : 2;
    const id = this.meService.me?.name;
    const mcu = '115.68.14.146';
    const jsonStr = JSON.stringify({ no, mode, id, layout: 1, mcu });
    (window as any).WSMEDIA.startCall(jsonStr);
  }

  checkDevice(): void {
    if (!isPlatformBrowser(this.platformId)) { return; }
    (window as any).WSMEDIA.cameraTest();
  }

  changeUrl(): void {
    if (!isPlatformBrowser(this.platformId)) { return; }
    (window as any).WSMEDIA.changeUrl();
  }
}
