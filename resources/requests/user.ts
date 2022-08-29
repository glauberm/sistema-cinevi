import * as crud from './crud';
// import * as versionable from './has-versions';

const URL_PREFIX = 'usuarios';

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

// export function paginateVersions(notifications, setData, setLinks, setMeta, setLoading, id, page = 1, options = null) {
//     versionable.paginateVersions(URL_PREFIX, notifications, setData, setLinks, setMeta, setLoading, id, page, options);
// }

// export function showVersion(notifications, setValues, setLoading, id, options = null) {
//     versionable.showVersion(URL_PREFIX, notifications, setValues, setLoading, id, options);
// }
