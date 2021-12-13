import * as mongoose from "mongoose";

export interface Inquiry extends mongoose.Document {
    _id: mongoose.Types.ObjectId;
    phone: string;
    password: string;
    title: string;
    content: string;
    answer: {
        content: string;
    } | undefined;
}

const schema = new mongoose.Schema({
    phone: {required: true, type: String},
    password: {required: true, type: String},
    title: {required: true, type: String},
    content: {required: true, type: String},

    answer: {
        type: new mongoose.Schema({
            content: {type: String, default: ''}
        }),
        required: false
    }
}, {
    timestamps: true,
    strict: 'throw'
});

export const InquiryModel = mongoose.model<Inquiry>('Inquiry', schema);
