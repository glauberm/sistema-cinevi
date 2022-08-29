import React from 'react';

import BookingCreatePage from '../pages/Booking/BookingCreatePage';
// import BookingVersionPage from '../pages/Booking/BookingVersionPage';
import BookingUpdatePage from '../pages/Booking/BookingUpdatePage';
// import BookingVersionIndexPage from '../pages/Booking/BookingVersionIndexPage.jsx~';
import BookingIndexPage from '../pages/Booking/BookingIndexPage';

export default {
    create: { path: '/reservas/adicionar', element: <BookingCreatePage /> },
    // version: { path: '/funcoes/versoes/:id', element: <BookingVersionPage /> },
    update: { path: '/reservas/:id', element: <BookingUpdatePage />, getPath: (id: string) => `/reservas/${id}` },
    // versionsIndex: { path: '/funcoes/:id/versoes', element: <BookingVersionIndexPage /> },
    index: { path: '/reservas', element: <BookingIndexPage /> },
};
