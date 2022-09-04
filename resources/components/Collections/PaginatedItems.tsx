import React, { useContext, useEffect, useState } from 'react';

import { NotificationsContext } from '../../contexts/NotificationsProvider';
import Items from './Items';
import Pagination from './Pagination';
import Spinner from '../Spinner';
import Message from '../Message';

export default function PaginatedItems(props) {
    const { paginateFn, linkToFn, selectFn, selected, children } = props;

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
                <div>
                    <Items
                        data={data}
                        linkToFn={linkToFn}
                        selectFn={selectFn}
                        selected={selected}
                        isLoading={isLoading}
                    >
                        {children}
                    </Items>
                    <Pagination links={links} meta={meta} paginate={paginate} isLoading={isLoading} />
                </div>
            );
        } else {
            return <Message>Nenhum resultado</Message>;
        }
    }

    return <Spinner />;
}
