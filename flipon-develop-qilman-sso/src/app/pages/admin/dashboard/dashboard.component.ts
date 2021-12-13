import { Component, OnInit } from '@angular/core';
import {Navigator} from '../../../utils/navigator';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.scss']
})
export class DashboardComponent implements OnInit {

  constructor(
    public navigator: Navigator
  ) { }

  ngOnInit(): void {
  }

}
