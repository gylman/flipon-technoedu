import * as mongoose from "mongoose";

export interface Request extends mongoose.Document {
    teacher: mongoose.Types.ObjectId;
    students: mongoose.Types.ObjectId[];
}

const schema = new mongoose.Schema({
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
    }
}, {
    timestamps: true,
    strict: 'throw'
});

export const RequestModel = mongoose.model<Request>('Request', schema);
