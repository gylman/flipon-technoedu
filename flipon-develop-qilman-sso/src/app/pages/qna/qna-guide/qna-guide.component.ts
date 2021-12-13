import {Component, OnInit} from '@angular/core';
import {Router, ActivatedRoute} from '@angular/router';

@Component({
  selector: 'app-qna-guide',
  templateUrl: './qna-guide.component.html',
  styleUrls: ['./qna-guide.component.scss'],
})
export class QnaGuideComponent implements OnInit {
  constructor(
    private router: Router,
    private route: ActivatedRoute
  ) {}

  ngOnInit(): void {}

  moveToBoard() {
    this.router.navigate(['board'], {relativeTo: this.route});
  }
}
