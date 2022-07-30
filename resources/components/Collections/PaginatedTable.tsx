import React, { useContext, useEffect, useState } from 'react';

import { NotificationsContext } from '../../contexts/NotificationsProvider';
import Table from '../../components/Collections/Table';
import Pagination from '../../components/Collections/Pagination';
import Spinner from '../Spinner';
import Message from '../Message';

export default function PaginatedTable(props) {
    const { paginateFn, children } = props;

    const [data, setData] = useState(null);
    const [links, setLinks] = useState(null);
    const [meta, setMeta] = useState(null);
    const [isLoading, setLoading] = useState(false);

    const notifications = useContext(NotificationsContext);

    const paginate = (page = 1) => {
        paginateFn(notifications, setData, setLinks, setMeta, setLoading, page);
    };

    useEffect(() => {
        paginate();
    }, []);

    if (data) {
        if (Boolean(data.length)) {
            return (
                <>
                    <Table data={data}>{children}</Table>
                    <Pagination links={links} meta={meta} paginate={paginate} />
                </>
            );
        } else {
            return <Message>Nenhum resultado</Message>;
        }
    }

    return <Spinner />;
}
