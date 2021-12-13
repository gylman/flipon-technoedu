import * as mongoose from "mongoose";

export interface Room extends mongoose.Document {
    number: number;
    isAvailable: boolean;
}

const schema = new mongoose.Schema({
    number: {
        required: true,
        type: Number
    },
    isAvailable: {
        required: true,
        default: true,
        type: Boolean
    }
}, {
    timestamps: true,
    strict: 'throw'
});

export const RoomModel = mongoose.model<Room>('Room', schema);
