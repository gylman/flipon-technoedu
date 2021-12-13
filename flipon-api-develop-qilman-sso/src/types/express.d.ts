import {User as BaseUser} from "../models/user";

declare global {
    namespace Express {
        interface User extends BaseUser {}
    }
}
