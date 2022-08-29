import React from 'react';

import ConfigurationPage from '../pages/Misc/ConfigurationPage';
import NotFoundPage from '../pages/Misc/NotFoundPage';

export default {
    configuration: { path: '/configuracoes', element: <ConfigurationPage /> },
    notFound: { path: '/nao-encontrada', element: <NotFoundPage /> },
};
