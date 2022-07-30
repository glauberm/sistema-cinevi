import React from 'react';
import { Route, Routes } from 'react-router-dom';

import SecureLayout from '../layouts/SecureLayout';
import PublicLayout from '../layouts/PublicLayout';
import PrivateRoute from './PrivateRoute';
import { publicRoutes, secureRoutes } from '.';

export default function Router() {
    return (
        <Routes>
            {secureRoutes.map((route, key) => (
                <Route
                    key={key}
                    path={route.path}
                    element={
                        <SecureLayout>
                            <PrivateRoute>{route.element}</PrivateRoute>
                        </SecureLayout>
                    }
                />
            ))}

            {publicRoutes.map((route, key) => (
                <Route key={key} path={route.path} element={<PublicLayout>{route.element}</PublicLayout>} />
            ))}
        </Routes>
    );
}
