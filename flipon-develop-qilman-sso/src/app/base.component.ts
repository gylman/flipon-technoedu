import {trackBy} from './utils/track-by';
import {CourseSubject} from './models/course.model';
import * as _ from 'lodash';

export class BaseComponent {
  // Functions
  trackBy = trackBy;
  keys = Object.keys;
  values = Object.values;
  _ = _;

  // Enums
  CourseSubject = CourseSubject;
}
