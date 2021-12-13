import * as mongoose from "mongoose";
import {isValidEmail} from "../utils/validate";
import {bool} from "aws-sdk/clients/signer";

export interface User extends mongoose.Document {
    _id: mongoose.Types.ObjectId;
    type: 'Student' | 'Teacher' | 'Admin' | 'Super';
    email: string;
    password: string;
    name: string;
    phone: string;
    // part: string | null; // organization the user is part of
    countryCode: string;

    status?: {
        isAccepted: boolean;
        isAvailable: boolean;
        mentorBox: string | null;
    };

    profile: {
        school: {
            name: string;
            major: string | undefined;
            cardImage: string | undefined;
        }
        address: {
            primary: string;
            code: string;
            secondary: string;
        }

        birthday: string;
        image: string;
        availableTime: string[];
        introduction: string | undefined;
        subject: string[];
        parent: string | undefined;
        isPublic: boolean | undefined;

        want: {
            courseStyle: string;
            type: string;
            subject: string[];
            timeInWeek: string;
        };

        hasMonitor: boolean;
        hasSpace: boolean;
    };

    payment: {
        bank: string | undefined;
        num: string | undefined;
        receipt: string | undefined;
    },

    notification: [{
        action: string | undefined;
        title: string;
        content: string;
        isShown: boolean;
    }] | undefined
}

const schema = new mongoose.Schema({
    type: {enum: ['Student', 'Teacher', 'Admin', 'Super'], required: true, type: String},
    email: {
        required: true,
        unique: true,
        type: String,
        validate: isValidEmail()
    },
    password: {required: true, type: String},
    name: {required: true, type: String},
    phone: {required: true, type: String},
    // part: {type: String},
    countryCode: {required: true, type: String},

    status: {
        type: new mongoose.Schema({
            isAccepted: {type: Boolean, default: false},
            isAvailable: {type: Boolean, default: true},
            mentorBox: {type: String, default: null},
        }),
        required: false
    },


    profile: {
        type: new mongoose.Schema({
            school: {
                type: new mongoose.Schema({
                    name: {required: true, type: String},
                    major: {type: String},
                    cardImage: {type: String}
                })
            },
            address: {
                type: new mongoose.Schema({
                    primary: {required: true, type: String},
                    code: {required: true, type: String},
                    secondary: {type: String, default: ''},
                }),
                required: true
            },

            birthday: {required: true, type: String},
            image: {type: String},
            availableTime: {type: [String], default: []},
            introduction: {type: String},
            courseStyle: {type: String},
            parent: {type: String},
            subject: {type: [String], enum: ['MATH', 'ENGLISH']},
            isPublic: {type: Boolean},

            want: {
                type: new mongoose.Schema({
                    courseStyle: {type: String, default: ''},
                    type: {type: String, default: ''},
                    subject: {type: [String], default: []},
                    timeInWeek: {type: String, default: ''}
                }),
                required: true,
                default: () => ({})
            },

            hasMonitor: {type: Boolean, default: false},
            hasSpace: {type: Boolean, default: false}
        }),
        required: false
    },

    payment: {
        type: new mongoose.Schema({
            bank: {type: String},
            num: {type: String},
            receipt: {type: String}
        }),
        required: false
    },

    notification: {
        type: [new mongoose.Schema({
            action: {type: [String], enum: ['']},
            title: {type: String, required: true},
            content: {type: String, required: true},
            isShown: {type: Boolean, required: true, default: false}
        }, {
            timestamps: true
        })]
    }
}, {
    timestamps: true,
    strict: 'throw'
});

schema.pre<User>('validate', function (next) {
    let isValid = true;
    if (this.type === 'Teacher') {
        if (
            !this.profile.school.major ||
            !this.profile.subject.length
        ) { isValid = false; }
    }

    isValid ? next() : next(Error());
});

export const UserModel = mongoose.model<User>('User', schema);
