import {ClrDatagridStateInterface} from '@clr/angular';
import {Observable} from 'rxjs';
import {finalize} from 'rxjs/operators';
import {BaseModel} from '../models/base.model';

export interface Executable<T> {
  loading: boolean;
  action: (data: Array<T> | ClrDatagridStateInterface) => Observable<any>;
}

export class PaginationItem<T extends BaseModel> {
  total: number;
  items: Array<T>;
  state: ClrDatagridStateInterface;
  executables: { [key: string]: Executable<T> };
  enabled?: boolean;
  selected: Array<T>;

  refresh(state?: ClrDatagridStateInterface) {
    this.state = state || this.state;
    state = this.state;
    const refresh: Executable<T> = this.executables.refresh;
    refresh.loading = true;
    refresh.action(state)
      .pipe(finalize(() => refresh.loading = false))
      .subscribe(
        value => {
          this.items = value.items;
          this.total = value.count;
        },
        error => {}
      );
  }

  exec(action: string) {
    const executables = this.executables[action];
    executables.loading = true;
    executables.action(this.selected)
      .pipe(finalize(() => {
        executables.loading = false;
        this.refresh();
      }))
      .subscribe();
  }
}
