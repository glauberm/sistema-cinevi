import React, { useContext, useEffect } from 'react';

import { isRebooted } from '../../services/auth';
import { NotificationsContext } from '../../contexts/NotificationsProvider';
import AuthenticationLoginForm from '../../forms/Authentication/AuthenticationLoginForm';

export default function (props) {
    const notifications = useContext(NotificationsContext);

    if (notifications === undefined) {
        throw new Error('O contexto das notificações não foi definido.');
    }

    useEffect(() => {
        isRebooted(notifications);
    }, []);

    return <AuthenticationLoginForm />;
}
