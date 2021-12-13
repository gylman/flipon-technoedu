import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { MentorBoxComponent } from './mentor-box.component';

describe('MentorBoxComponent', () => {
  let component: MentorBoxComponent;
  let fixture: ComponentFixture<MentorBoxComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ MentorBoxComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(MentorBoxComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
