import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { QnaPostComponent } from './qna-post.component';

describe('QnaPostComponent', () => {
  let component: QnaPostComponent;
  let fixture: ComponentFixture<QnaPostComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ QnaPostComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(QnaPostComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
