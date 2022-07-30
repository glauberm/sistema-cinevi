import React from 'react';

import ProductionRoleCreatePage from '../pages/ProductionRole/ProductionRoleCreatePage';
// import ProductionRoleRemovedIndexPage from '../pages/ProductionRole/ProductionRoleRemovedIndexPage';
// import ProductionRoleRemovedPage from '../pages/ProductionRole/ProductionRoleRemovedPage';
// import ProductionRoleVersionPage from '../pages/ProductionRole/ProductionRoleVersionPage';
import ProductionRoleUpdatePage from '../pages/ProductionRole/ProductionRoleUpdatePage';
// import ProductionRoleVersionIndexPage from '../pages/ProductionRole/ProductionRoleVersionIndexPage.jsx~';
import ProductionRoleIndexPage from '../pages/ProductionRole/ProductionRoleIndexPage';

export default {
    create: { path: '/funcoes/adicionar', element: <ProductionRoleCreatePage /> },
    // removedIndex: { path: '/funcoes/lixeira', element: <ProductionRoleRemovedIndexPage /> },
    // removed: { path: '/funcoes/lixeira/:id', element: <ProductionRoleRemovedPage /> },
    // version: { path: '/funcoes/versoes/:id', element: <ProductionRoleVersionPage /> },
    update: { path: '/funcoes/:id', element: <ProductionRoleUpdatePage /> },
    // versionsIndex: { path: '/funcoes/:id/versoes', element: <ProductionRoleVersionIndexPage /> },
    index: { path: '/funcoes', element: <ProductionRoleIndexPage /> },
};
