import * as mongoose from "mongoose";

export interface Log extends mongoose.Document {
    teacher: mongoose.Types.ObjectId;
}

const schema = new mongoose.Schema({
    password: {required: true, type: String},
});

export const LogModel = mongoose.model<Log>('Log', schema);
