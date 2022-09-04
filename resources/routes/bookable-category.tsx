import React from 'react';

import BookableCategoryCreatePage from '../pages/BookableCategory/BookableCategoryCreatePage';
import BookableCategoryUpdatePage from '../pages/BookableCategory/BookableCategoryUpdatePage';
import BookableCategoryIndexPage from '../pages/BookableCategory/BookableCategoryIndexPage';

export default {
    create: { path: '/categorias-de-reservaveis/adicionar', element: <BookableCategoryCreatePage /> },
    update: {
        path: '/categorias-de-reservaveis/:id',
        element: <BookableCategoryUpdatePage />,
        getPath: (id: string) => `/categorias-de-reservaveis/${id}`,
    },
    index: { path: '/categorias-de-reservaveis', element: <BookableCategoryIndexPage /> },
};
