import React from 'react';
import { useParams } from 'react-router-dom';

import UserCreateOrUpdateForm from '../../forms/User/UserCreateOrUpdateForm';
import UserRemoveForm from '../../forms/User/UserRemoveForm';
import Title from '../../components/Title';

export default function () {
    const params = useParams();

    return (
        <div>
            <Title>Editar Usuário</Title>

            <UserCreateOrUpdateForm id={params.id} />

            <hr className="invisible my-5" />

            <UserRemoveForm id={params.id} />
        </div>
    );
}
