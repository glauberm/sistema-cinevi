import api, { handleError } from '../services/api';
// import { api, handleError } from '../contexts/ApiProvider';

export default function (notifications, setAuthorized, gate, userId = null) {
    api.get('/usuario-autenticado')
        .then((response) => {
            const authenticatedUser = response.data.data;

            switch (gate) {
                case 'isAdmin':
                    setAuthorized(authenticatedUser && authenticatedUser.roles.includes('admin'));
                    break;
                case 'isAdminAndIsNotUser':
                    setAuthorized(
                        authenticatedUser &&
                            authenticatedUser.roles.includes('admin') &&
                            authenticatedUser.id !== parseInt(userId, 10)
                    );
                    break;
                case 'isDepartment':
                    setAuthorized(authenticatedUser && authenticatedUser.roles.includes('department'));
                    break;
                case 'isWarehouse':
                    setAuthorized(authenticatedUser && authenticatedUser.roles.includes('warehouse'));
                    break;
                default:
                    setAuthorized(false);
                    break;
            }
        })
        .catch((error) => {
            notifications.add(handleError(error), 'danger');
        });
}
