import React from 'react';

import UserCreatePage from '../pages/User/UserCreatePage';
import UserUpdatePage from '../pages/User/UserUpdatePage';
import UserIndexPage from '../pages/User/UserIndexPage';

export default {
    create: { path: '/usuarios/adicionar', element: <UserCreatePage /> },
    update: { path: '/usuarios/:id', element: <UserUpdatePage />, getPath: (id: string) => `/usuarios/${id}` },
    index: { path: '/usuarios', element: <UserIndexPage /> },
};
