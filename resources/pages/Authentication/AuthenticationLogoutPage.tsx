import React, { useContext, useEffect } from 'react';
import { Navigate, useNavigate } from 'react-router-dom';

import { NotificationsContext } from '../../contexts/NotificationsProvider';
import { logout } from '../../requests/authentication';

export default function AuthenticationLogoutPage() {
    const notifications = useContext(NotificationsContext);
    const navigate = useNavigate();

    useEffect(() => {
        logout(notifications, navigate);
    }, []);

    return null;
}
