import React from 'react';

import BookingCreateOrUpdateForm from '../../forms/Booking/BookingCreateOrUpdateForm';
import Title from '../../components/Title';

export default function () {
    return (
        <div>
            <Title>Realizar Reserva</Title>

            <BookingCreateOrUpdateForm />
        </div>
    );
}
