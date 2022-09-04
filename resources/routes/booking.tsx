import React from 'react';

import BookingCreatePage from '../pages/Booking/BookingCreatePage';
import BookingUpdatePage from '../pages/Booking/BookingUpdatePage';
import BookingIndexPage from '../pages/Booking/BookingIndexPage';

export default {
    create: { path: '/reservas/adicionar', element: <BookingCreatePage /> },
    update: { path: '/reservas/:id', element: <BookingUpdatePage />, getPath: (id: string) => `/reservas/${id}` },
    index: { path: '/reservas', element: <BookingIndexPage /> },
};
