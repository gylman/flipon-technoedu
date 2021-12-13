import {async, ComponentFixture, TestBed} from '@angular/core/testing';

import {QnaGuideComponent} from './qna-guide.component';

describe('QnaGuideComponent', () => {
  let component: QnaGuideComponent;
  let fixture: ComponentFixture<QnaGuideComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [QnaGuideComponent]
    })
      .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(QnaGuideComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
