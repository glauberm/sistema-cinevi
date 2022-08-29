import React from 'react';

import BookableCreateOrUpdateForm from '../../forms/Bookable/BookableCreateOrUpdateForm';
import Title from '../../components/Title';

export default function () {
    return (
        <div>
            <Title>Adicionar Reservável</Title>

            <BookableCreateOrUpdateForm />
        </div>
    );
}
