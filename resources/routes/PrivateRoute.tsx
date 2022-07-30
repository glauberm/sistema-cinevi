import React from 'react';
import { Navigate, useLocation } from 'react-router-dom';

import { isAuthenticated } from '../services/auth';
import authentication from './authentication';

export default function PrivateRoute(props) {
    const { children } = props;

    const location = useLocation();

    if (isAuthenticated() === true) {
        return children;
    }

    return <Navigate to={authentication.login.path} state={{ redirectTo: location.pathname }} />;
}
