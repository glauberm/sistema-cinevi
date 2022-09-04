import React from 'react';

import BookableCreatePage from '../pages/Bookable/BookableCreatePage';
import BookableUpdatePage from '../pages/Bookable/BookableUpdatePage';
import BookableIndexPage from '../pages/Bookable/BookableIndexPage';

export default {
    create: { path: '/reservaveis/adicionar', element: <BookableCreatePage /> },
    update: {
        path: '/reservaveis/:id',
        element: <BookableUpdatePage />,
        getPath: (id: string) => `/reservaveis/${id}`,
    },
    index: { path: '/reservaveis', element: <BookableIndexPage /> },
};
