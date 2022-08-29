import * as crud from './crud';

const URL_PREFIX = 'reservas';

export function paginate(notifications, setData, setLinks, setMeta, setLoading, page = 1, options = null) {
    crud.paginate(URL_PREFIX, notifications, setData, setLinks, setMeta, setLoading, page, options);
}

export function create(notifications, navigate, setLoading, values, options = null) {
    crud.create(URL_PREFIX, notifications, navigate, setLoading, values, options);
}

export function show(notifications, setValues, setLoading, id, options = null) {
    crud.show(URL_PREFIX, notifications, setValues, setLoading, id, options);
}

export function update(notifications, navigate, setLoading, id, values, options = null) {
    crud.update(URL_PREFIX, notifications, navigate, setLoading, id, values, options);
}

export function remove(notifications, navigate, setLoading, id, options = null) {
    crud.remove(URL_PREFIX, notifications, navigate, setLoading, id, options);
}
