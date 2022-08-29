import React from 'react';
import { useParams } from 'react-router-dom';

import BookableCreateOrUpdateForm from '../../forms/Bookable/BookableCreateOrUpdateForm';
import BookableRemoveForm from '../../forms/Bookable/BookableRemoveForm';
import Title from '../../components/Title';

export default function () {
    const params = useParams();

    return (
        <div>
            <Title>Editar Usuário</Title>

            <BookableCreateOrUpdateForm id={params.id} />

            <hr className="invisible my-5" />

            <BookableRemoveForm id={params.id} />
        </div>
    );
}
