import * as mongoose from "mongoose";
import {Inquiry, InquiryModel} from "../models/inquiry";
import {HttpError} from "../utils/http";

export async function createInquiry(body: any): Promise<Inquiry> {
    return await InquiryModel.create(body);
}

export async function findInquiries(options: any = {}) {
    return InquiryModel
        .find(options.conditions)
        .sort(options.sort)
        .select('-password');
}

export async function updateInquiry(id: string | mongoose.Types.ObjectId, update: any): Promise<void> {
    if (!mongoose.Types.ObjectId.isValid(id))
        throw new HttpError(400);
    const result = await InquiryModel.findByIdAndUpdate(id, {$set: update});
    if (!result)
        throw new HttpError(400);
    return;
}
