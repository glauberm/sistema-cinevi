import React from 'react';
import { Link } from 'react-router-dom';

import routes from '../../routes/bookable-category';
import Title from '../../components/Title';
import BookableCategoryCollection from '../../collections/BookableCategory/BookableCategoryCollection';

export default function () {
    return (
        <div>
            <Title>Categorias de Reserváveis</Title>

            <BookableCategoryCollection />

            <hr className="invisible" />

            <Link className="btn btn-primary btn-lg" to={routes.create.path}>
                Adicionar
            </Link>
        </div>
    );
}
