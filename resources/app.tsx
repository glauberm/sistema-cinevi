import React from 'react';
import ReactDOM from 'react-dom/client';
import { BrowserRouter } from 'react-router-dom';

import NotificationsProvider from './contexts/NotificationsProvider';
import DialogsProvider from './contexts/DialogsProvider';
import Router from './routes/Router';

const rootElement = document.getElementById('root');

if (rootElement === null) {
    throw new DOMException('Elemento #root não encontrado.', 'NotFoundError');
}

const root = ReactDOM.createRoot(rootElement);

root.render(
    <React.StrictMode>
        <BrowserRouter>
            <NotificationsProvider>
                <DialogsProvider>
                    <Router />
                </DialogsProvider>
            </NotificationsProvider>
        </BrowserRouter>
    </React.StrictMode>
);
