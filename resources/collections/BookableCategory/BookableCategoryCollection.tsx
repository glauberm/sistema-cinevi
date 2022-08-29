import React from 'react';
import { Link } from 'react-router-dom';

import { paginate } from '../../requests/bookable-category';
import routes from '../../routes/bookable-category';
import PaginatedTable from '../../components/Collections/PaginatedTable';

export default function () {
    return (
        <PaginatedTable paginateFn={paginate}>
            {(bookableCategory, key) => (
                <tr key={key}>
                    <td>
                        <Link to={routes.update.getPath(bookableCategory.id)}>{bookableCategory.title}</Link>
                    </td>
                </tr>
            )}
        </PaginatedTable>
    );
}
