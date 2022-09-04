import React from 'react';

import UserUpdatePage from '../pages/User/UserUpdatePage';
import UserIndexPage from '../pages/User/UserIndexPage';

export default {
    update: { path: '/usuarios/:id', element: <UserUpdatePage />, getPath: (id: string) => `/usuarios/${id}` },
    index: { path: '/usuarios', element: <UserIndexPage /> },
};
