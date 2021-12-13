import * as mongoose from "mongoose";

export enum MsgStatus {
    Pending = 0,
    Sent = 1,
    Authorized = 2,
    Used = 3,
    Error = 4
}

export interface SMS extends mongoose.Document {
    authCode: string;
    status: MsgStatus;
}

const schema = new mongoose.Schema({
    authCode: {
        required: true,
        type: String
    },
    status: {
        default: MsgStatus.Pending,
        type: MsgStatus
    }
}, {
    timestamps: true,
    strict: 'throw'
});

export const SMSModel = mongoose.model<SMS>('SMS', schema);
