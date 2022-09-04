import React from 'react';

import ConfigurationUpdateForm from '../../forms/Configuration/ConfigurationUpdateForm';
import Title from '../../components/Title';

export default function ConfigurationUpdatePage() {
    return (
        <div>
            <Title>Configurações</Title>

            <ConfigurationUpdateForm />

            <hr className="invisible my-5" />
        </div>
    );
}
