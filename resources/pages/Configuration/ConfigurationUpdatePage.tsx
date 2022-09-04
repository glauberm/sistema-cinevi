import React from 'react';

import ConfigurationUpdateForm from '../../forms/Configuration/ConfigurationUpdateForm';
import Title from '../../components/Title';

export default function () {
    return (
        <div>
            <Title>Configurações</Title>

            <ConfigurationUpdateForm />

            <hr className="invisible my-5" />
        </div>
    );
}
