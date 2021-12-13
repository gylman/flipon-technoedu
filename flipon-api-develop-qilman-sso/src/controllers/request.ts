import {Request, RequestModel} from "../models/request";
import * as mongoose from "mongoose";
import {User} from "../models/user";
import {Course} from "../models/course";


export async function findAll(): Promise<Request[]> {
    try {
        return await RequestModel.find().populate('teacher students');
    } catch (err) {
        throw err;
    }
}

export async function findById(id: mongoose.Types.ObjectId): Promise<Request | null> {
    try {
        return await RequestModel.findById(id).populate('teacher students')
    } catch (err) {
        throw err;
    }
}

// export async function create(id: mongoose.Types.ObjectId, user: User): Promise<User | null> {
//     try {
//         // Check payment status
//         const paymentValid = await PaymentController.isUserPaymentValid(user);
//         // Payment Required
//         if (!paymentValid) {
//             return null;
//         }
//         // 교사가 유효한지 확인
//         const teacher = await UserController.findById(id);
//         if (teacher === null || teacher.userType === 'Student') {
//             return null;
//         }
//         // Request 추가
//         await insert(teacher, [user]);
//
//         return teacher;
//     } catch (err) {
//         throw err;
//     }
// }

/**
 * @description 학생과 교사 정보로 Request를 생성하여 저장
 * @returns 실패하면 undefined, 성공하면 새 Request
 */
export async function insert(teacher: User, students: User[]): Promise<Request> {
    return await new RequestModel({
        students,
        teacher
    }).save();
}

// export async function accept(id: mongoose.Types.ObjectId): Promise<Course> {
//     try {
//         const request = await findById(id);
//         if (request === null) {
//             throw new Error('Request Not Found');
//         }
//         // const course = await CourseController.create(request);
//         await request.remove();
//         return course;
//     } catch (err) {
//         throw err;
//     }
// }

export async function deny(id: mongoose.Types.ObjectId): Promise<void> {
    try {
        await RequestModel.findByIdAndDelete(id);
        return;
    } catch (err) {
        throw err;
    }
}
