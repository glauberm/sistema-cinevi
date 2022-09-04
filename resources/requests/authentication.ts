import axios from 'axios';

import api, { handleError } from '../services/api';
// import { api, handleError } from '../contexts/ApiProvider';
import { setAuthenticated } from '../services/auth';
import authentication from '../routes/authentication';

/**
 * @param values
 * @param notifications
 * @param navigate
 */
export function login(values, notifications, navigate, setLoading) {
    setLoading(true);

    axios
        .get(`${process.env.MIX_APP_BASE_WEB_URL}/sanctum/csrf-cookie`)
        .then((response) => {
            api.post('/entrada', values)
                .then((response) => {
                    setAuthenticated(true);
                    navigate(authentication.profile.path);
                })
                .catch((error) => {
                    notifications.add(handleError(error), 'danger');
                })
                .finally(() => {
                    setLoading(false);
                });
        })
        .catch((error) => {
            notifications.add(handleError(error), 'danger');
        });
}

/**
 * @param notifications
 * @param navigate
 */
export function logout(notifications, navigate) {
    api.post('/saida')
        .then((response) => {
            setAuthenticated(false);
            notifications.add(response.data.message, 'success');
        })
        .catch((error) => {
            notifications.add(handleError(error), 'danger');
        })
        .finally(() => {
            navigate(authentication.login.path);
        });
}

export function getAuthenticatedUser(notifications, setAuthenticatedUser) {
    api.get('/usuario-autenticado')
        .then((response) => {
            setAuthenticatedUser(response.data.data);
        })
        .catch((error) => {
            notifications.add(handleError(error), 'danger');
        });
}
