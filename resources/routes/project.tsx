import React from 'react';

import ProjectCreatePage from '../pages/Project/ProjectCreatePage';
// import ProjectVersionPage from '../pages/Project/ProjectVersionPage';
import ProjectUpdatePage from '../pages/Project/ProjectUpdatePage';
// import ProjectVersionIndexPage from '../pages/Project/ProjectVersionIndexPage.jsx~';
import ProjectIndexPage from '../pages/Project/ProjectIndexPage';

export default {
    create: { path: '/projetos/adicionar', element: <ProjectCreatePage /> },
    // version: { path: '/funcoes/versoes/:id', element: <ProjectVersionPage /> },
    update: { path: '/projetos/:id', element: <ProjectUpdatePage />, getPath: (id: string) => `/projetos/${id}` },
    // versionsIndex: { path: '/funcoes/:id/versoes', element: <ProjectVersionIndexPage /> },
    index: { path: '/projetos', element: <ProjectIndexPage /> },
};
