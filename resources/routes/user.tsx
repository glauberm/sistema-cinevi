import React from 'react';

import UserCreatePage from '../pages/User/UserCreatePage';
// import UserVersionPage from '../pages/User/UserVersionPage';
import UserUpdatePage from '../pages/User/UserUpdatePage';
// import UserVersionIndexPage from '../pages/User/UserVersionIndexPage.jsx~';
import UserIndexPage from '../pages/User/UserIndexPage';

export default {
    create: { path: '/usuarios/adicionar', element: <UserCreatePage /> },
    // version: { path: '/funcoes/versoes/:id', element: <UserVersionPage /> },
    update: { path: '/usuarios/:id', element: <UserUpdatePage />, getPath: (id: string) => `/usuarios/${id}` },
    // versionsIndex: { path: '/funcoes/:id/versoes', element: <UserVersionIndexPage /> },
    index: { path: '/usuarios', element: <UserIndexPage /> },
};
