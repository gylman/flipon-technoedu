import {SchemaTypeOpts} from "mongoose";

export const isValidEmail = (): SchemaTypeOpts.ValidateOpts => {
    return {
        validator: (v) => { return true; },
        message: (v) => v.value
    };
};
