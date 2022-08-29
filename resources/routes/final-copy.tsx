import React from 'react';

import FinalCopyCreatePage from '../pages/FinalCopy/FinalCopyCreatePage';
// import FinalCopyVersionPage from '../pages/FinalCopy/FinalCopyVersionPage';
import FinalCopyUpdatePage from '../pages/FinalCopy/FinalCopyUpdatePage';
// import FinalCopyVersionIndexPage from '../pages/FinalCopy/FinalCopyVersionIndexPage.jsx~';
import FinalCopyIndexPage from '../pages/FinalCopy/FinalCopyIndexPage';

export default {
    create: { path: '/copias-finais/adicionar', element: <FinalCopyCreatePage /> },
    // version: { path: '/funcoes/versoes/:id', element: <FinalCopyVersionPage /> },
    update: {
        path: '/copias-finais/:id',
        element: <FinalCopyUpdatePage />,
        getPath: (id: string) => `/copias-finais/${id}`,
    },
    // versionsIndex: { path: '/funcoes/:id/versoes', element: <FinalCopyVersionIndexPage /> },
    index: { path: '/copias-finais', element: <FinalCopyIndexPage /> },
};
