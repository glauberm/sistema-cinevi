import React from 'react';

import BookableCategoryCreateOrUpdateForm from '../../forms/BookableCategory/BookableCategoryCreateOrUpdateForm';
import Title from '../../components/Title';

export default function BookableCategoryCreatePage() {
    return (
        <div>
            <Title>Adicionar Categoria de Reservável</Title>

            <BookableCategoryCreateOrUpdateForm />
        </div>
    );
}
