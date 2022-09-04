import React, { createContext, useContext, useEffect, useState } from 'react';

import { ApiContext } from './ApiProvider';

export const AuthContext = createContext(undefined);

export default function AuthProvider(props) {
    const [authenticatedUser, setAuthenticatedUser] = useState(null);
    const [isAuthenticated, setIsAuthenticated] = useState(null);
    const apiProvider = useContext(ApiContext);

    const hasRole = (role) => {
        if (authenticatedUser !== null) {
            authenticatedUser.roles.includes(role);
        }
    };

    useEffect(() => {
        apiProvider.api
            .get('/usuario-autenticado')
            .then((response) => {
                setAuthenticatedUser(response.data.resource);
            })
            .catch((error) => {
                setAuthenticatedUser(false);
            });
    }, []);

    useEffect(() => {
        if (authenticatedUser !== null) {
            setIsAuthenticated(authenticatedUser !== false);
        }
    }, [authenticatedUser]);

    return (
        <AuthContext.Provider value={{ authenticatedUser, setAuthenticatedUser, isAuthenticated, hasRole }}>
            {authenticatedUser !== null && props.children}
        </AuthContext.Provider>
    );
}
