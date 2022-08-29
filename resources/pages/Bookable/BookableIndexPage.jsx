import React from 'react';
import { Link } from 'react-router-dom';

import routes from '../../routes/bookable';
import Title from '../../components/Title';
import BookableCollection from '../../collections/Bookable/BookableCollection';

export default function () {
    return (
        <div>
            <Title>Reserváveis</Title>

            <BookableCollection />

            <hr className="invisible" />

            <Link className="btn btn-primary btn-lg" to={routes.create.path}>
                Adicionar
            </Link>
        </div>
    );
}
