import React from 'react';

import ProductionCategoryCreatePage from '../pages/ProductionCategory/ProductionCategoryCreatePage';
// import ProductionCategoryVersionPage from '../pages/ProductionCategory/ProductionCategoryVersionPage';
import ProductionCategoryUpdatePage from '../pages/ProductionCategory/ProductionCategoryUpdatePage';
// import ProductionCategoryVersionIndexPage from '../pages/ProductionCategory/ProductionCategoryVersionIndexPage.jsx~';
import ProductionCategoryIndexPage from '../pages/ProductionCategory/ProductionCategoryIndexPage';

export default {
    create: { path: '/modalidades/adicionar', element: <ProductionCategoryCreatePage /> },
    // version: { path: '/funcoes/versoes/:id', element: <ProductionCategoryVersionPage /> },
    update: {
        path: '/modalidades/:id',
        element: <ProductionCategoryUpdatePage />,
        getPath: (id: string) => `/modalidades/${id}`,
    },
    // versionsIndex: { path: '/funcoes/:id/versoes', element: <ProductionCategoryVersionIndexPage /> },
    index: { path: '/modalidades', element: <ProductionCategoryIndexPage /> },
};
