import React from 'react';
import ReactDOM from 'react-dom/client';
import { BrowserRouter } from 'react-router-dom';

import NotificationsProvider from './contexts/NotificationsProvider';
import Router from './routes/Router';

const rootElement = document.getElementById('root');

if (rootElement === null) {
    throw new Error('Elemento #root não encontrado.');
}

const root = ReactDOM.createRoot(rootElement);

root.render(
    <React.StrictMode>
        <BrowserRouter>
            <NotificationsProvider>
                <Router />
            </NotificationsProvider>
        </BrowserRouter>
    </React.StrictMode>
);
