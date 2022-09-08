import { handleError } from '../contexts/ApiProvider';

export function paginate(
    urlPrefix,
    api,
    notifications,
    setData,
    setLinks,
    setMeta,
    setLoading,
    page = 1,
    options = null
) {
    setLoading(true);

    const urlParams = new URLSearchParams();

    if (options && options.urlParams) {
        Object.keys(options.urlParams).forEach((key) => {
            if (options.urlParams[key]) {
                urlParams.append(key, options.urlParams[key].toString());
            }
        });
    }

    urlParams.append('page', page.toString());

    api.get(`/${urlPrefix}?${urlParams}`)
        .then((response) => {
            setData(response.data.data);
            setLinks(response.data.links);
            setMeta(response.data.meta);
        })
        .catch((error) => {
            notifications.add(handleError(error), 'danger');
        })
        .finally(() => {
            setLoading(false);
        });
}

export function create(urlPrefix, api, notifications, navigate, setLoading, values, options = null) {
    setLoading(true);

    api.post(`/${urlPrefix}/adicionar`, values)
        .then((response) => {
            notifications.add(response.data.message, 'success');
            navigate(`/${urlPrefix}`);
        })
        .catch((error) => {
            notifications.add(handleError(error), 'danger');
            setLoading(false);
        });
}

export function show(urlPrefix, api, notifications, setValues, setLoading, id, options = null) {
    setLoading(true);

    api.get(`/${urlPrefix}/${id}`)
        .then((response) => {
            let { data } = response.data;

            if (options && options.transformData) {
                data = options.transformData(data);
            }

            setValues(data);
        })
        .catch((error) => {
            notifications.add(handleError(error), 'danger');
        })
        .finally(() => {
            setLoading(false);
        });
}

export function update(urlPrefix, api, notifications, navigate, setLoading, id, values, options = null) {
    setLoading(true);

    api.put(`/${urlPrefix}/${id}/editar`, values)
        .then((response) => {
            notifications.add(response.data.message, 'success');

            if (options && options.navigateTo) {
                navigate(options.navigateTo);
            } else {
                navigate(`/${urlPrefix}`);
            }
        })
        .catch((error) => {
            notifications.add(handleError(error), 'danger');
            setLoading(false);
        });
}

export function remove(urlPrefix, api, notifications, navigate, setLoading, id, options = null) {
    setLoading(true);

    api.delete(`/${urlPrefix}/${id}/remover`)
        .then((response) => {
            notifications.add(response.data.message, 'success');
            navigate(`/${urlPrefix}`);
        })
        .catch((error) => {
            notifications.add(handleError(error), 'danger');
            setLoading(false);
        });
}
