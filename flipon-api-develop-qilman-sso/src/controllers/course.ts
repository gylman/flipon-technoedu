import {assignRoom, releaseRoom} from "./room";
import {Course, CourseModel, CourseStatus} from "../models/course";
import * as mongoose from "mongoose";
import {UserModel} from "../models/user";
import {HttpError} from "../utils/http";
import {updateUserNotification} from "./user";

export async function createCourse(body: any): Promise<Course> {
    body.status = CourseStatus.Active;
    return await CourseModel.create(body);
}

/**
 * @param id _id of course to update
 * @param update Values to update
 */
export async function updateCourse(id: string, update: any): Promise<void> {
    if (!mongoose.Types.ObjectId.isValid(id))
        throw new HttpError(400);

    switch (update.status) {
        case CourseStatus.Active:
            update.room = await assignRoom();
            break;
        case CourseStatus.Cancelled:
        case CourseStatus.Terminated:
            update.room = null;
            break;
        default:
            throw new HttpError(400);
    }

    const course = await CourseModel.findByIdAndUpdate(id, {$set: update}, {new: true});

    if (update.room === null)
        await releaseRoom(course?.room);

    if (course != null) {
        const notification = {
            title: '',
            content: ''
        }

        switch (update.status) {
            case CourseStatus.Active:
                notification.title = '수업 시작';
                notification.content = `<${course.name}> 수업이 시작되었습니다.`;
                break;
            case CourseStatus.Cancelled:
                notification.title = '수업 취소';
                notification.content = `<${course.name}> 수업이 취소되었습니다.`;
                break;
            case CourseStatus.Terminated:
                notification.title = '수업 종료';
                notification.content = `<${course.name}> 수업이 종료되었습니다.`;
                break;
            default:
                throw new HttpError(400);
        }

        await updateUserNotification(course.teacher, notification);
        for (const student of course.students) {
            await updateUserNotification(student, notification);
        }
    }
}

export async function findCourses(options: any = {}): Promise<{count: number, items: Array<Course>}> {
    const courses = await CourseModel
        .find(options.conditions)
        .skip(options.offset)
        .limit(options.limit)
        .populate('room')
        .populate('students', '-password -status')
        .populate('teacher', '-password -status')
        .sort(options.sort);
    return {count: await CourseModel.count(options.conditions), items: courses};
}
