import axios from 'axios';

import { handleError } from '../contexts/ApiProvider';
import authentication from '../routes/authentication';

export function login(api, auth, notifications, navigate, setLoading, values) {
    setLoading(true);

    axios
        .get(`${process.env.MIX_APP_BASE_WEB_URL}/sanctum/csrf-cookie`)
        .then((response) => {
            api.post('/entrada', values)
                .then((response) => {
                    auth.setAuthenticatedUser(response.data.resource);
                    navigate(authentication.profile.path);
                })
                .catch((error) => {
                    notifications.add(handleError(error), 'danger', true);
                })
                .finally(() => {
                    setLoading(false);
                });
        })
        .catch((error) => {
            notifications.add(handleError(error), 'danger');
        });
}

export function logout(api, auth, notifications, navigate) {
    api.post('/saida')
        .then((response) => {
            auth.setAuthenticatedUser(false);
            notifications.add(response.data.message, 'success');
        })
        .catch((error) => {
            notifications.add(handleError(error), 'danger');
        })
        .finally(() => {
            navigate(authentication.login.path);
        });
}

export function register(api, notifications, navigate, setLoading, values) {
    setLoading(true);

    api.post('/cadastro', values)
        .then((response) => {
            notifications.add(response.data.message, 'success', true);
            navigate(authentication.login.path);
        })
        .catch((error) => {
            notifications.add(handleError(error), 'danger');
        })
        .finally(() => {
            setLoading(false);
        });
}

export function finalizeRegistration(api, notifications, setLoading, url) {
    setLoading(true);

    api.put(url)
        .then((response) => {
            notifications.add(response.data.message, 'success', true);
        })
        .catch((error) => {
            notifications.add(handleError(error), 'danger');
        })
        .finally(() => {
            setLoading(false);
        });
}

export function requestResetPassword(api, notifications, navigate, setLoading, values) {
    setLoading(true);

    api.post('/solicitar-redefinir-senha', values)
        .then((response) => {
            notifications.add(response.data.message, 'success', true);
            navigate(authentication.login.path);
        })
        .catch((error) => {
            notifications.add(handleError(error), 'danger');
        })
        .finally(() => {
            setLoading(false);
        });
}

export function resetPassword(api, notifications, navigate, setLoading, url, values) {
    setLoading(true);

    api.put(url, values)
        .then((response) => {
            notifications.add(response.data.message, 'success');
            navigate(authentication.login.path);
        })
        .catch((error) => {
            notifications.add(handleError(error), 'danger');
        })
        .finally(() => {
            setLoading(false);
        });
}

export function requestUpdateEmail(api, notifications, setLoading, values) {
    setLoading(true);

    api.post('/solicitar-atualizar-email', values)
        .then((response) => {
            notifications.add(response.data.message, 'success', true);
        })
        .catch((error) => {
            notifications.add(handleError(error), 'danger');
        })
        .finally(() => {
            setLoading(false);
        });
}

export function updateEmail(api, notifications, setLoading, url) {
    setLoading(true);

    api.put(url)
        .then((response) => {
            notifications.add(response.data.message, 'success', true);
        })
        .catch((error) => {
            notifications.add(handleError(error), 'danger');
        })
        .finally(() => {
            setLoading(false);
        });
}

export function updatePassword(api, notifications, setLoading, url) {
    setLoading(true);

    api.put(url)
        .then((response) => {
            notifications.add(response.data.message, 'success', true);
        })
        .catch((error) => {
            notifications.add(handleError(error), 'danger');
        })
        .finally(() => {
            setLoading(false);
        });
}
