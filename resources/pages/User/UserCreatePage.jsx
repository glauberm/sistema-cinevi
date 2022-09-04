import React from 'react';

import UserCreateOrUpdateForm from '../../forms/User/UserCreateOrUpdateForm';
import Title from '../../components/Title';

export default function UserCreatePage() {
    return (
        <div>
            <Title>Adicionar Usuário</Title>

            <UserCreateOrUpdateForm />
        </div>
    );
}
