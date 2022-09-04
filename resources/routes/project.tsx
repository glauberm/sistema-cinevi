import React from 'react';

import ProjectCreatePage from '../pages/Project/ProjectCreatePage';
import ProjectUpdatePage from '../pages/Project/ProjectUpdatePage';
import ProjectIndexPage from '../pages/Project/ProjectIndexPage';

export default {
    create: { path: '/projetos/adicionar', element: <ProjectCreatePage /> },
    update: { path: '/projetos/:id', element: <ProjectUpdatePage />, getPath: (id: string) => `/projetos/${id}` },
    index: { path: '/projetos', element: <ProjectIndexPage /> },
};
