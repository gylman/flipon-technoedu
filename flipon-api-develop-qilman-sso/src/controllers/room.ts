/**
 * @description 학생과 교사 정보로 Request를 생성하여 저장
 * @param end 마지막 방 번호
 *
 * @returns 반환 값 없음
 */
import {Room, RoomModel} from "../models/room";
import * as mongoose from "mongoose";

export async function createRoom(end: number): Promise<void> {
    for (let i = 0; i < end; i++) {
        const room = await RoomModel.findOne({ number: i });
        if (room == null) {
            await new RoomModel({
                number: i
            }).save();
        }
    }
}

/**
 * @description 방 목록 요청
 *
 * @returns 방 목록
 */
export async function getRoomList(): Promise<Array<Room>> {
    return RoomModel.find({}).sort({number: 1});
}

/**
 * @description 사용 불가능한 상태로 변경
 *
 * @returns 사용 불가능한 상태로 변경한 방
 */
export async function assignRoom(): Promise<string> {
    let room = await RoomModel.findOneAndUpdate({isAvailable: true}, {$set: {isAvailable: false}}, {new: true});

    if (!room) {
        const last = (await RoomModel.findOne().sort('-number'))?.number ?? 0;
        room = await RoomModel.create({number: last + 1, isAvailable: false});
    }

    return room._id;
}

/**
 * @description 사용 가능한 상태로 변경
 *
 * @returns 반환 값 없음
 */
export async function releaseRoom(id: mongoose.Types.ObjectId | null | undefined): Promise<void> {
    await RoomModel.findByIdAndUpdate(id, { $set: { isAvailable: true } });
    return;
}
