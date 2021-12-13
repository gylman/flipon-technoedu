import {Component, OnInit} from '@angular/core';
import {MeService} from '../../../service/me.service';
import {CourseModel, CourseStatus} from '../../../models/course.model';

@Component({
  selector: 'app-courses',
  templateUrl: './courses.component.html',
  styleUrls: ['./courses.component.scss']
})
export class CoursesComponent implements OnInit {
  requestedCourses: Array<CourseModel>;
  activeCourses: Array<CourseModel>;
  terminatedCourses: Array<CourseModel>;

  constructor(
    private meService: MeService
  ) { }

  ngOnInit(): void {
    this.meService
      .getCourses()
      .subscribe(
        value => {
          this.requestedCourses = value.filter(v => v.status === CourseStatus.Requested);
          this.activeCourses = value.filter(v => v.status === CourseStatus.Active);
          this.terminatedCourses = value.filter(v => v.status === CourseStatus.Terminated);
        },
        error => {}
      );
  }

}
