import {Component, OnInit, ViewChild} from '@angular/core';
import {UserService} from '../../service/user.service';
import {UserModel} from '../../models/user.model';
import {MeService} from '../../service/me.service';
import {Navigator} from '../../utils/navigator';
import {finalize, map} from 'rxjs/operators';
import {ClrLoadingState, ClrWizard} from '@clr/angular';

@Component({
  selector: 'app-teachers',
  templateUrl: './teachers.component.html',
  styleUrls: ['./teachers.component.scss']
})
export class TeachersComponent implements OnInit {
  teachers: UserModel[] = [];
  selectedTeacher: UserModel;
  requestWizardOpen = false;
  requestBtnState: ClrLoadingState = ClrLoadingState.DEFAULT;
  @ViewChild('wizard') wizard: ClrWizard;
  subject = '';

  constructor(
    private userService: UserService,
    private meService: MeService,
    private navigator: Navigator
  ) { }

  ngOnInit(): void {
    this.loadTeachers();
  }

  changeSubject(subject: string): void {
    this.subject = subject;
    this.loadTeachers();
  }

  loadTeachers(): void {
    this.userService.getTeachers(this.subject)
      .pipe(map((x) => x.items))
      .subscribe(
        teachers => {
          this.teachers = teachers;
        },
        error => {}
      );
  }

  confirm(teacher: UserModel): void {
    this.selectedTeacher = teacher;
    this.wizard.reset();
    this.requestWizardOpen = true;
  }

  request(): void {
    this.requestBtnState = ClrLoadingState.LOADING;
    this.meService
      .requestCourse(this.selectedTeacher.id)
      .subscribe(
        result => {
          this.requestBtnState = ClrLoadingState.SUCCESS;
          this.navigator.courses();
        },
        error => {
          this.requestBtnState = ClrLoadingState.ERROR;
        }
      );
  }
}
