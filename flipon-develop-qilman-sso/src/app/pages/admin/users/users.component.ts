import { Component, OnInit } from '@angular/core';
import {UserService} from '../../../service/user.service';
import {UserModel} from '../../../models/user.model';
import {Executable, PaginationItem} from '../../../utils/pagination-item';
import {ClrDatagridStateInterface} from '@clr/angular';

@Component({
  selector: 'app-users',
  templateUrl: './users.component.html',
  styleUrls: ['./users.component.scss']
})
export class UsersComponent implements OnInit {
  conditions: {
    type?: string;
    page?: number;
    size?: number;
  } = {};

  user: PaginationItem<UserModel> = {
    total: 0,
    items: [],
    selected: [],
    state: {},
    executables: {
      refresh: {
        loading: true,
        action: (state: ClrDatagridStateInterface) => {
          this.conditions.page = state.page?.current;
          this.conditions.size = state.page?.size;
          return this.userService
            .getUsers(this.conditions);
        }
      }
    },
    refresh: PaginationItem.prototype.refresh,
    exec: PaginationItem.prototype.exec
  };

  constructor(
    private userService: UserService
  ) { }

  ngOnInit(): void {
  }
}
