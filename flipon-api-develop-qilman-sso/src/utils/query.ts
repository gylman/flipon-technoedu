import * as express from "express";

export const parseQuery = (req: express.Request): {offset: number, limit: number, conditions: any} => {
    const options = {
        offset: 0,
        limit: 20,
        sort: '-createdAt',
        conditions: {}
    };

    let page = parseInt(req.query.page as string) || 1;
    let size = parseInt(req.query.size as string) || 20;
    options.offset = size * (page - 1);
    options.limit = size;
    if (req.query.sort) options.sort = req.query.sort as string

    delete req.query.page;
    delete req.query.size;
    delete req.query.sort;

    options.conditions = req.query;

    Object.keys(options.conditions).forEach(key => !options.conditions[key] && delete options.conditions[key])

    return options;
}
