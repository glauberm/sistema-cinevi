import * as crud from './crud';

const URL_PREFIX = 'projetos';

export function paginate(api, notifications, setData, setLinks, setMeta, setLoading, page = 1, options = null) {
    crud.paginate(URL_PREFIX, api, notifications, setData, setLinks, setMeta, setLoading, page, options);
}

export function create(api, notifications, navigate, setLoading, values, options = null) {
    crud.create(URL_PREFIX, api, notifications, navigate, setLoading, values, options);
}

export function show(api, notifications, setValues, setLoading, id, options = null) {
    crud.show(URL_PREFIX, api, notifications, setValues, setLoading, id, options);
}

export function update(api, notifications, navigate, setLoading, id, values, options = null) {
    crud.update(URL_PREFIX, api, notifications, navigate, setLoading, id, values, options);
}

export function remove(api, notifications, navigate, setLoading, id, options = null) {
    crud.remove(URL_PREFIX, api, notifications, navigate, setLoading, id, options);
}
