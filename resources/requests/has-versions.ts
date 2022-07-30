import api, { handleError } from '../services/api';

/**
 * Faz a requisição de listagem de versões de um item.
 *
 * @export
 * @param {*} urlPrefix
 * @param {*} component
 * @param {*} id
 * @param {*} page
 */
export function paginateVersions(urlPrefix, component, id, page) {
    const { notifications } = component.props;

    component.setState({ isLoading: true });

    api.get(`/${urlPrefix}/${id}/versoes?page=${page}`)
        .then((response) => {
            component.setState({
                data: response.data.data,
                links: response.data.links,
                meta: response.data.meta,
            });
        })
        .catch((error) => {
            notifications.add(handleError(error), 'danger');
        })
        .finally(() => {
            component.setState({ isLoading: false });
        });
}

/**
 * Faz a requisição de exibição da versão de um item.
 *
 * @export
 * @param {*} urlPrefix
 * @param {*} stateKey
 * @param {*} component
 * @param {*} id
 * @param {*} [options=null]
 */
export function showVersion(urlPrefix, stateKey, component, id, options = null) {
    const { notifications } = component.props;

    component.setState({ isLoading: true });

    api.get(`/${urlPrefix}/versoes/${id}`)
        .then((response) => {
            let { data } = response.data;

            let payload = JSON.parse(data.payload);

            if (options && options.transformData) {
                payload = options.transformData(payload);
            }

            component.setState({
                version: data,
                [stateKey]: payload,
            });
        })
        .catch((error) => {
            notifications.add(handleError(error), 'danger');
        })
        .finally(() => {
            component.setState({ isLoading: false });
        });
}
