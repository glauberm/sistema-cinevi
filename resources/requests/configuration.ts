import * as crud from './crud';

const URL_PREFIX = 'configuracoes';

export function show(notifications, setValues, setLoading, options = null) {
    crud.show(URL_PREFIX, notifications, setValues, setLoading, '1', options);
}

export function update(notifications, navigate, setLoading, values, options = null) {
    crud.update(URL_PREFIX, notifications, navigate, setLoading, '1', values, options);
}
