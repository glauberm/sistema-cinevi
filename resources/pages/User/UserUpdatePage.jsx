import React from 'react';
import { useParams } from 'react-router-dom';

import UserUpdateForm from '../../forms/User/UserUpdateForm';
import UserRemoveForm from '../../forms/User/UserRemoveForm';
import Title from '../../components/Title';

export default function UserUpdatePage() {
    const params = useParams();

    return (
        <div>
            <Title>Editar Usuário</Title>

            <UserUpdateForm id={params.id} />

            <hr className="invisible my-5" />

            <UserRemoveForm id={params.id} />
        </div>
    );
}
