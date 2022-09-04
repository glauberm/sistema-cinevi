import React from 'react';

import ProductionCategoryCreatePage from '../pages/ProductionCategory/ProductionCategoryCreatePage';
import ProductionCategoryUpdatePage from '../pages/ProductionCategory/ProductionCategoryUpdatePage';
import ProductionCategoryIndexPage from '../pages/ProductionCategory/ProductionCategoryIndexPage';

export default {
    create: { path: '/modalidades/adicionar', element: <ProductionCategoryCreatePage /> },
    update: {
        path: '/modalidades/:id',
        element: <ProductionCategoryUpdatePage />,
        getPath: (id: string) => `/modalidades/${id}`,
    },
    index: { path: '/modalidades', element: <ProductionCategoryIndexPage /> },
};
