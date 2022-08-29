import React from 'react';

import BookableCategoryCreateOrUpdateForm from '../../forms/BookableCategory/BookableCategoryCreateOrUpdateForm';
import Title from '../../components/Title';

export default function () {
    return (
        <div>
            <Title>Adicionar Categoria de Reservável</Title>

            <BookableCategoryCreateOrUpdateForm />
        </div>
    );
}
