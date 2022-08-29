import { useContext, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';

import { NotificationsContext } from '../../contexts/NotificationsProvider';
import { logout } from '../../requests/authentication';

export default function () {
    const notifications = useContext(NotificationsContext);
    const navigate = useNavigate();

    useEffect(() => {
        logout(notifications, navigate);
    }, []);

    return null;
}
