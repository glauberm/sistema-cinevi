import React, { useEffect } from 'react';
import { Navigate, Route, Routes, useLocation } from 'react-router-dom';

import authentication from './authentication';
import user from './user';
import booking from './booking';
import bookable from './bookable';
import bookableCategory from './bookable-category';
import project from './project';
import finalCopy from './final-copy';
import productionRole from './production-role';
import productionCategory from './production-category';
import misc from './misc';
import SecureLayout from '../layouts/SecureLayout';
import PublicLayout from '../layouts/PublicLayout';
import BaseLayout from '../layouts/BaseLayout';

export const secureRoutes = [
    authentication.logout,
    authentication.profile,
    // authentication.requestUpdateEmail,
    // authentication.updateEmail,
    // authentication.updatePassword,
    misc.configuration,
    ...Object.values(user),
    ...Object.values(booking),
    ...Object.values(bookable),
    ...Object.values(bookableCategory),
    ...Object.values(project),
    ...Object.values(finalCopy),
    ...Object.values(productionRole),
    ...Object.values(productionCategory),
];

export const publicRoutes = [
    authentication.login,
    authentication.register,
    authentication.requestReset,
    // authentication.requestResetPassword,
    // authentication.resetPassword,
];

export default function Router() {
    const { pathname } = useLocation();

    useEffect(() => {
        window.scroll(0, 0);
    }, [pathname]);

    return (
        <Routes>
            {secureRoutes.map((route, key) => (
                <Route key={key} path={route.path} element={<SecureLayout>{route.element}</SecureLayout>} />
            ))}

            {publicRoutes.map((route, key) => (
                <Route key={key} path={route.path} element={<PublicLayout>{route.element}</PublicLayout>} />
            ))}

            <Route path={misc.notFound.path} element={<BaseLayout>{misc.notFound.element}</BaseLayout>} />
            <Route path="*" element={<Navigate to={misc.notFound.path} />} />
        </Routes>
    );
}
