import React, { useContext, useEffect, useState } from 'react';

import { paginate } from '../requests/production-category';
import { ApiContext } from '../contexts/ApiProvider';
import { NotificationsContext } from '../contexts/NotificationsProvider';
import PaginatedItems from '../components/Collections/PaginatedItems';

export default function ProductionCategoryCollection(props) {
    const { linkToFn, selectFn, selected } = props;

    const [data, setData] = useState(null);
    const [links, setLinks] = useState(null);
    const [meta, setMeta] = useState(null);
    const [isLoading, setLoading] = useState(false);

    const notifications = useContext(NotificationsContext);
    const apiProvider = useContext(ApiContext);

    const doPaginate = (page = 1) => {
        paginate(apiProvider.api, notifications, setData, setLinks, setMeta, setLoading, page);
    };

    useEffect(() => {
        doPaginate();
    }, []);

    return (
        <div>
            <PaginatedItems
                data={data}
                links={links}
                meta={meta}
                paginate={doPaginate}
                linkToFn={linkToFn}
                selected={selected}
                selectFn={selectFn}
                isLoading={isLoading}
            >
                {(item) => <span>{item.title}</span>}
            </PaginatedItems>
        </div>
    );
}
