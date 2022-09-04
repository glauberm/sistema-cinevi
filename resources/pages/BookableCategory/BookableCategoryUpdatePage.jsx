import React from 'react';
import { useParams } from 'react-router-dom';

import BookableCategoryCreateOrUpdateForm from '../../forms/BookableCategory/BookableCategoryCreateOrUpdateForm';
import BookableCategoryRemoveForm from '../../forms/BookableCategory/BookableCategoryRemoveForm';
import Title from '../../components/Title';

export default function BookableCategoryUpdatePage() {
    const params = useParams();

    return (
        <div>
            <Title>Editar Categoria de Reservável</Title>

            <BookableCategoryCreateOrUpdateForm id={params.id} />

            <hr className="invisible my-5" />

            <BookableCategoryRemoveForm id={params.id} />
        </div>
    );
}
