import React from 'react';
import { Link } from 'react-router-dom';

import routes from '../../routes/booking';
import Title from '../../components/Title';
import BookingCollection from '../../collections/Booking/BookingCollection';

export default function () {
    return (
        <div>
            <Title>Reservas</Title>

            <BookingCollection linkToFn={(item) => routes.update.getPath(item.id)} />

            <hr className="invisible" />

            <Link className="btn btn-primary btn-lg" to={routes.create.path}>
                Adicionar
            </Link>
        </div>
    );
}
