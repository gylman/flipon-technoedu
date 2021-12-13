import * as jwt from 'jsonwebtoken';
const privateKey = process.env.JWT_KEY ?? '';

export async function sign(id: string): Promise<String> {
    return new Promise((resolve, reject) => {
        jwt.sign({
            "id": id,
            iat: Math.floor(Date.now() / 1000)
        }, privateKey, {
            expiresIn: "1d"
        }, (err: any, token: any) => {
            if (err) { reject(err); }
            else resolve(token);
        });
    });
}

export async function verify(token: string): Promise<{ id: string, iat: Number, exp: Number }> {
    return new Promise((resolve, reject) => {
        jwt.verify(token, privateKey, (err: any, decoded: any) => {
            if (err) reject(err);
            else resolve(decoded as { id: string, iat: Number, exp: Number });
        });
    });
}
