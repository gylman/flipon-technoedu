import * as mongoose from "mongoose";
import {HttpError} from "../utils/http";
import {Review, ReviewModel} from "../models/review";

export async function createReview(body: any): Promise<Review> {
    return await ReviewModel.create(body);
}

export async function findReviewById(id: string | mongoose.Types.ObjectId) {
    if (!mongoose.Types.ObjectId.isValid(id))
        throw new HttpError(400);
    return ReviewModel
        .findById(id)
        .populate('writer', '-password -status');
}

export async function findReviews(options: any = {}) {
    return ReviewModel
        .find(options.conditions)
        .sort(options.sort)
        .populate('writer', '-password -status');
}

export async function updateReview(id: string | mongoose.Types.ObjectId, update: any): Promise<void> {
    if (!mongoose.Types.ObjectId.isValid(id))
        throw new HttpError(400);
    const result = await ReviewModel.findByIdAndUpdate(id, {$set: update});
    if (!result)
        throw new HttpError(400);
    return;
}
