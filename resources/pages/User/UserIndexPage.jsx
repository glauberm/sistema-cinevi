import React from 'react';

import routes from '../../routes/user';
import Title from '../../components/Title';
import UserCollection from '../../collections/UserCollection';

export default function UserIndexPage() {
    return (
        <div>
            <Title>Usuários</Title>

            <UserCollection linkToFn={(item) => routes.update.getPath(item.id)} />
        </div>
    );
}
