import React from 'react';
import { Link } from 'react-router-dom';

import { paginate } from '../../requests/booking';
import routes from '../../routes/booking';
import PaginatedTable from '../../components/Collections/PaginatedTable';

export default function () {
    return (
        <PaginatedTable paginateFn={paginate}>
            {(booking, key) => (
                <tr key={key}>
                    <td>
                        <Link to={routes.update.getPath(booking.id)}>{booking.code}</Link>
                    </td>
                </tr>
            )}
        </PaginatedTable>
    );
}
