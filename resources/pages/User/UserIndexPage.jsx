import React from 'react';
import { Link } from 'react-router-dom';

import routes from '../../routes/user';
import Title from '../../components/Title';
import UserCollection from '../../collections/User/UserCollection';

export default function UserIndexPage() {
    return (
        <div>
            <Title>Usuários</Title>

            <UserCollection linkToFn={(item) => routes.update.getPath(item.id)} />

            <hr className="invisible" />

            <Link className="btn btn-primary btn-lg" to={routes.create.path}>
                Adicionar
            </Link>
        </div>
    );
}
