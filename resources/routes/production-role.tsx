import React from 'react';

import ProductionRoleCreatePage from '../pages/ProductionRole/ProductionRoleCreatePage';
import ProductionRoleUpdatePage from '../pages/ProductionRole/ProductionRoleUpdatePage';
import ProductionRoleIndexPage from '../pages/ProductionRole/ProductionRoleIndexPage';

export default {
    create: { path: '/funcoes/adicionar', element: <ProductionRoleCreatePage /> },
    update: { path: '/funcoes/:id', element: <ProductionRoleUpdatePage />, getPath: (id: string) => `/funcoes/${id}` },
    index: { path: '/funcoes', element: <ProductionRoleIndexPage /> },
};
