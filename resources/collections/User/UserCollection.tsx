import React from 'react';
import { Link } from 'react-router-dom';

import { paginate } from '../../requests/user';
import routes from '../../routes/user';
import PaginatedTable from '../../components/Collections/PaginatedTable';

export default function () {
    return (
        <PaginatedTable paginateFn={paginate}>
            {(user, key) => (
                <tr key={key}>
                    <td>
                        <Link to={routes.update.getPath(user.id)}>{user.email}</Link>
                    </td>
                </tr>
            )}
        </PaginatedTable>
    );
}
