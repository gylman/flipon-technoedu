export class HttpError extends Error {
    status: number;
    message: string;
    raw: Error | undefined;

    constructor(status: number, raw?: Error) {
        super();
        Object.setPrototypeOf(this, HttpError.prototype);

        this.status = status;
        this.raw = raw;
        this.message = raw?.message ?? ''
    }
}
