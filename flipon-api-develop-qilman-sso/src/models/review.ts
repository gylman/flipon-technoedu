import * as mongoose from "mongoose";

export interface Review extends mongoose.Document {
    _id: mongoose.Types.ObjectId;
    writer: mongoose.Types.ObjectId;
    title: string;
    content: string;
}

const schema = new mongoose.Schema({
    writer: {required: true, ref: 'User', type: mongoose.Schema.Types.ObjectId},
    title: {required: true, type: String},
    content: {required: true, type: String},
}, {
    timestamps: true,
    strict: 'throw'
});

export const ReviewModel = mongoose.model<Review>('Review', schema);
