import {User, UserModel} from "../models/user";
import * as mongoose from "mongoose";
import {compare, encrypt} from "../utils/crypto";
import {HttpError} from "../utils/http";
import {createTechnoEduUser} from "../utils/technoedu";

export async function findUserById(id: mongoose.Types.ObjectId | undefined): Promise<User | null> {
    const user = await UserModel.findById(id).select('-password');
    if (user === null) {
        return null;
    }
    return user;
}

export async function findUserByCredentials(email: string, password: string): Promise<User | null> {
    const user = await UserModel.findOne({email});
    if (!user) return null;
    return await compare(user?.password ?? '', password) ? user : null;
}

export async function findUserByEmail(email: string): Promise<User | null> {
    return UserModel.findOne({email});
}

export async function findUsers(options: any = {}): Promise<{count: number, items: Array<User>}> {
    const users = await UserModel
        .find(options.conditions)
        .skip(options.offset)
        .limit(options.limit)
        .select('-password -status')
        .sort(options.sort);
    return {count: await UserModel.count(options.conditions), items: users};
}

export async function createUser(body: any): Promise<void> {
    console.log('controllers/user.ts:  function createUser()')
    const smsId = body.smsId;
    // if (!smsId || !(await useForAuth(smsId))) { throw 403; }

    if (!body.password) { throw new HttpError(400); }
    console.log('await encrypt()...')
    body.password = await encrypt(body.password);
    console.log('await encrypt() done.')

    let user_part = body.part;
    delete body.part;
    console.log('UserModel.create() running...')
    let user = await UserModel.create(body);
    console.log('UserModel.create() done.');

    // Create the same user at TechnoEdu as well
    console.log('createTechnoEduUser() running...')
    createTechnoEduUser(user, user_part);
    console.log('createTechnoEduUser() done.')
}

export async function updateUser(id: string | mongoose.Types.ObjectId, update: any): Promise<void> {
    if (!mongoose.Types.ObjectId.isValid(id))
        throw new HttpError(400);
    const result = await UserModel.findByIdAndUpdate(id, {$set: update});
    if (!result)
        throw new HttpError(400);
    return;
}

export async function updateUserNotification(id: string | mongoose.Types.ObjectId, notification: any): Promise<void> {
    if (!mongoose.Types.ObjectId.isValid(id))
        throw new HttpError(400);
    const result = await UserModel.findByIdAndUpdate(id, {$push: {notification}});
    if (!result)
        throw new HttpError(400);
    return;
}
