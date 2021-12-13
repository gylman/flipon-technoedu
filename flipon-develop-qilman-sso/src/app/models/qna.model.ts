export enum QnaCategory {
  Teacher = '선생님',
  Payment = '수강권',
  Enroll = '수강신청',
  Lecture = '수업',
  Profile = '프로필 작성',
  Signup = '회원가입',
  Device = '장비'
}

export class QnaModel {
  category: QnaCategory;
  title: string;
  question: string;
  date: Date;
  attachment: File | null;
  password: string;
  userName: string;
  qnaId: number;
  answer: {
    adminName: string;
    title: string;
    content: string;
    date: Date;
    attachment: File | null;
  } | null;
}
