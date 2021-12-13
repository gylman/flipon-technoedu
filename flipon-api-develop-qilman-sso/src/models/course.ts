import * as mongoose from "mongoose";

export enum CourseStatus {
    Cancelled = 'CANCELLED',
    Requested = 'REQUESTED',
    Active = 'ACTIVE',
    Terminated = 'TERMINATED'
}

export interface Course extends mongoose.Document {
    name: string;
    students: mongoose.Types.ObjectId[];
    teacher: mongoose.Types.ObjectId;
    subject: string;
    room: mongoose.Types.ObjectId | null;
    status: number;
}

const schema = new mongoose.Schema({
    name: {
        default: '',
        type: String
    },
    students: {
        default: [],
        type: [{
            ref: 'User',
            type: mongoose.Schema.Types.ObjectId
        }]
    },
    teacher: {
        ref: 'User',
        type: mongoose.Schema.Types.ObjectId
    },
    subject: {
        default: '',
        type: String
    },
    room: {
        ref: 'Room',
        type: mongoose.Schema.Types.ObjectId,
        default: null
    },
    status: {
        default: CourseStatus.Requested,
        type: CourseStatus
    }
}, {
    timestamps: true,
    strict: 'throw'
});

export const CourseModel = mongoose.model<Course>('Course', schema);
