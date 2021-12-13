import {Component, OnInit} from '@angular/core';
import {CourseService} from '../../../service/course.service';
import {CourseModel, CourseStatus} from '../../../models/course.model';
import {finalize, mergeMap} from 'rxjs/operators';
import {FormControl, FormGroup, Validators} from '@angular/forms';
import {ClrDatagridStateInterface, ClrLoadingState} from '@clr/angular';
import {UserModel} from '../../../models/user.model';
import {UserService} from '../../../service/user.service';
import {PaginationItem} from '../../../utils/pagination-item';
import {from} from 'rxjs';

@Component({
  selector: 'app-requests',
  templateUrl: './requests.component.html',
  styleUrls: ['./requests.component.scss']
})
export class RequestsComponent implements OnInit {
  course: PaginationItem<CourseModel> = {
    total: 0,
    items: [],
    enabled: true,
    selected: [],
    state: {},
    executables: {
      refresh: {
        loading: true,
        action: (state: ClrDatagridStateInterface) => {
          return this.courseService
            .getCourses({
              status: CourseStatus.Requested,
              page: state.page?.current,
              size: state.page?.size
            });
        }
      },
      approve: {
        loading: false,
        action: (selected: Array<CourseModel>) => {
          return from(selected)
            .pipe(mergeMap((course: CourseModel) => this.courseService.approveCourse(course.id)));
        }
      }
    },
    refresh: PaginationItem.prototype.refresh,
    exec: PaginationItem.prototype.exec
  };

  teacher: PaginationItem<UserModel> = {
    total: 0,
    items: [],
    enabled: false,
    selected: [],
    state: {},
    executables: {
      refresh: {
        loading: false,
        action: (state: ClrDatagridStateInterface) => {
          return this.userService
            .getUsers({
              type: 'Teacher',
              status: {
                isAccepted: false
              },
              page: state.page?.current,
              size: state.page?.size
            });
        }
      },
      approve: {
        loading: false,
        action: (selected: Array<UserModel>) => {
          return from(selected)
            .pipe(mergeMap((teacher: UserModel) => this.userService.approveTeacher(teacher.id)));
        }
      }
    },
    refresh: PaginationItem.prototype.refresh,
    exec: PaginationItem.prototype.exec
  };

  constructor(
    private courseService: CourseService,
    private userService: UserService
  ) { }

  ngOnInit(): void {
  }
}
