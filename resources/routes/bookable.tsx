import React from 'react';

import BookableCreatePage from '../pages/Bookable/BookableCreatePage';
// import BookableVersionPage from '../pages/Bookable/BookableVersionPage';
import BookableUpdatePage from '../pages/Bookable/BookableUpdatePage';
// import BookableVersionIndexPage from '../pages/Bookable/BookableVersionIndexPage.jsx~';
import BookableIndexPage from '../pages/Bookable/BookableIndexPage';

export default {
    create: { path: '/reservaveis/adicionar', element: <BookableCreatePage /> },
    // version: { path: '/funcoes/versoes/:id', element: <BookableVersionPage /> },
    update: {
        path: '/reservaveis/:id',
        element: <BookableUpdatePage />,
        getPath: (id: string) => `/reservaveis/${id}`,
    },
    // versionsIndex: { path: '/funcoes/:id/versoes', element: <BookableVersionIndexPage /> },
    index: { path: '/reservaveis', element: <BookableIndexPage /> },
};
