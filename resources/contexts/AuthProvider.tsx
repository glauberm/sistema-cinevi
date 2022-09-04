import React, { createContext, useContext, useEffect, useState } from 'react';

import { getAuthenticatedUser } from '../requests/authentication';
import { NotificationsContext } from './NotificationsProvider';

export const AuthContext = createContext(undefined);

export default function AuthProvider(props) {
    const [user, setUser] = useState(null);
    const notifications = useContext(NotificationsContext);

    useEffect(() => {
        getAuthenticatedUser(notifications, setUser);
    }, []);

    return <AuthContext.Provider value={{ user }}>{props.children}</AuthContext.Provider>;
}
