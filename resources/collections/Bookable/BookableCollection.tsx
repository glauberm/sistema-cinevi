import React from 'react';
import { Link } from 'react-router-dom';

import { paginate } from '../../requests/bookable';
import routes from '../../routes/bookable';
import PaginatedTable from '../../components/Collections/PaginatedTable';

export default function () {
    return (
        <PaginatedTable paginateFn={paginate}>
            {(bookable, key) => (
                <tr key={key}>
                    <td>
                        <Link to={routes.update.getPath(bookable.id)}>{bookable.name}</Link>
                    </td>
                </tr>
            )}
        </PaginatedTable>
    );
}
