import axios from 'axios';

import { handleError } from '../contexts/ApiProvider';
import authentication from '../routes/authentication';

/**
 * @param values
 * @param notifications
 * @param navigate
 */
export function login(api, auth, values, notifications, navigate, setLoading) {
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
