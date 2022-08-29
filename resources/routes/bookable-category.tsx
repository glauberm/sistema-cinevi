import React from 'react';

import BookableCategoryCreatePage from '../pages/BookableCategory/BookableCategoryCreatePage';
// import BookableCategoryVersionPage from '../pages/BookableCategory/BookableCategoryVersionPage';
import BookableCategoryUpdatePage from '../pages/BookableCategory/BookableCategoryUpdatePage';
// import BookableCategoryVersionIndexPage from '../pages/BookableCategory/BookableCategoryVersionIndexPage.jsx~';
import BookableCategoryIndexPage from '../pages/BookableCategory/BookableCategoryIndexPage';

export default {
    create: { path: '/categorias-de-reservaveis/adicionar', element: <BookableCategoryCreatePage /> },
    // version: { path: '/funcoes/versoes/:id', element: <BookableCategoryVersionPage /> },
    update: {
        path: '/categorias-de-reservaveis/:id',
        element: <BookableCategoryUpdatePage />,
        getPath: (id: string) => `/categorias-de-reservaveis/${id}`,
    },
    // versionsIndex: { path: '/funcoes/:id/versoes', element: <BookableCategoryVersionIndexPage /> },
    index: { path: '/categorias-de-reservaveis', element: <BookableCategoryIndexPage /> },
};
