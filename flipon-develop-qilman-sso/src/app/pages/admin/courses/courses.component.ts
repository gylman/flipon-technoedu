import {Component, OnInit, ViewChild} from '@angular/core';
import {CourseModel} from '../../../models/course.model';
import {CourseService} from '../../../service/course.service';
import {PaginationItem} from '../../../utils/pagination-item';
import {UserModel} from '../../../models/user.model';
import {ClrDatagridStateInterface, ClrWizard} from '@clr/angular';
import {UserService} from '../../../service/user.service';
import {BaseComponent} from '../../../base.component';
import {finalize} from 'rxjs/operators';

@Component({
  selector: 'app-courses',
  templateUrl: './courses.component.html',
  styleUrls: ['./courses.component.scss']
})
export class CoursesComponent extends BaseComponent implements OnInit {
  courseWizardOpen = false;
  @ViewChild('wizard') courseWizard: ClrWizard;
  newCourse = new CourseModel();

  course: PaginationItem<CourseModel> = {
    total: 0,
    items: [],
    selected: [],
    state: {},
    executables: {
      refresh: {
        loading: true,
        action: (state: ClrDatagridStateInterface) => {
          return this.courseService
            .getCourses({
              status,
              page: state.page?.current,
              size: state.page?.size
            });
        }
      }
    },
    refresh: PaginationItem.prototype.refresh,
    exec: PaginationItem.prototype.exec
  };

  student: PaginationItem<UserModel> = {
    total: 0,
    items: [],
    selected: [],
    enabled: true,
    state: {},
    executables: {
      refresh: {
        loading: true,
        action: (state: ClrDatagridStateInterface) => {
          return this.userService
            .getUsers({
              type: 'Student',
              page: state.page?.current,
              size: state.page?.size
            });
        }
      }
    },
    refresh: PaginationItem.prototype.refresh,
    exec: PaginationItem.prototype.exec
  };

  teacher: PaginationItem<UserModel> = {
    total: 0,
    items: [],
    selected: [],
    enabled: false,
    state: {},
    executables: {
      refresh: {
        loading: true,
        action: (state: ClrDatagridStateInterface) => {
          return this.userService
            .getUsers({
              type: 'Teacher',
              page: state.page?.current,
              size: state.page?.size
            });
        }
      }
    },
    refresh: PaginationItem.prototype.refresh,
    exec: PaginationItem.prototype.exec
  };

  constructor(
    private courseService: CourseService,
    private userService: UserService
  ) {
    super();
  }

  ngOnInit(): void {
  }

  openCourseWizard(): void {
    this.courseWizard?.reset();
    this.newCourse.clear();
    this.courseWizardOpen = true;
  }

  createCourse(course: CourseModel): void {
    console.log(course.pack);
    this.courseService
      .createCourse(course.pack)
      .pipe(finalize(() => this.course.refresh()))
      .subscribe();
  }
}
