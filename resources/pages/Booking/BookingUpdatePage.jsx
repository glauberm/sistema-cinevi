import React from 'react';
import { useParams } from 'react-router-dom';

import BookingCreateOrUpdateForm from '../../forms/Booking/BookingCreateOrUpdateForm';
import BookingRemoveForm from '../../forms/Booking/BookingRemoveForm';
import Title from '../../components/Title';

export default function () {
    const params = useParams();

    return (
        <div>
            <Title>Editar Reserva</Title>

            <BookingCreateOrUpdateForm id={params.id} />

            <hr className="invisible my-5" />

            <BookingRemoveForm id={params.id} />
        </div>
    );
}
