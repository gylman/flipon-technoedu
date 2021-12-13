import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { QnaModel, QnaCategory } from '../../../models/qna.model';
import { POSTDATA } from '../../../shared/components/posting/posting.component';

@Component({
  selector: 'app-qna-post',
  templateUrl: './qna-post.component.html',
  styleUrls: ['./qna-post.component.scss']
})
export class QnaPostComponent implements OnInit {
  public data: QnaModel;
  public postData: POSTDATA = {
    title: '',
    content: '',
    attachment: null
  };
  public categories: string[] = [];

  constructor(
    private router: Router,
    private route: ActivatedRoute) {
    Object.keys(QnaCategory).filter(key => this.categories.push(QnaCategory[key]))
    this.data = new QnaModel();
    this.data.date = new Date();
    // TODO: username, qnaId
  }

  ngOnInit(): void {
    console.log(this.data);
  }
  onSubmit = (dataFromPosting: POSTDATA) => {
    console.log(this.data);
    this.data.title = dataFromPosting.title;
    this.data.question = dataFromPosting.content;
    this.data.attachment = dataFromPosting.attachment;
    console.log(this.data);
    // TODO: redirect to previous page.
  }

  onBack = () => {
    console.log(this.route);
    this.router.navigate(['../'], { relativeTo: this.route.parent });
  }

}
