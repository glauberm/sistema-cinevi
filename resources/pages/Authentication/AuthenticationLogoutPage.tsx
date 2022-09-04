import { useContext, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';

import { NotificationsContext } from '../../contexts/NotificationsProvider';
import { ApiContext } from '../../contexts/ApiProvider';
import { AuthContext } from '../../contexts/AuthProvider';
import { logout } from '../../requests/authentication';

export default function AuthenticationLogoutPage() {
    const notifications = useContext(NotificationsContext);
    const apiProvider = useContext(ApiContext);
    const authProvider = useContext(AuthContext);
    const navigate = useNavigate();

    useEffect(() => {
        logout(apiProvider.api, authProvider, notifications, navigate);
    }, []);

    return null;
}
