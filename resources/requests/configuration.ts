import * as crud from './crud';

const URL_PREFIX = 'configuracoes';

export function show(api, notifications, setValues, setLoading, options = null) {
    crud.show(URL_PREFIX, api, notifications, setValues, setLoading, '1', options);
}

export function update(api, notifications, navigate, setLoading, values, options = null) {
    crud.update(URL_PREFIX, api, notifications, navigate, setLoading, '1', values, options);
}
