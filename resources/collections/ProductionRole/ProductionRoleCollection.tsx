import React from 'react';
import { Link } from 'react-router-dom';

import { paginate } from '../../requests/production-role';
import routes from '../../routes/production-role';
import PaginatedTable from '../../components/Collections/PaginatedTable';

export default function () {
    return (
        <PaginatedTable paginateFn={paginate}>
            {(productionRole, key) => (
                <tr key={key}>
                    <td>
                        <Link to={routes.update.getPath(productionRole.id)}>{productionRole.title}</Link>
                    </td>
                </tr>
            )}
        </PaginatedTable>
    );
}
