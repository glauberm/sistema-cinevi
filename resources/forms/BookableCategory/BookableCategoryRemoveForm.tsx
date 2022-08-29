import React, { useContext, useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';

import { remove } from '../../requests/bookable-category';
import authorize from '../../requests/authorization';
import { NotificationsContext } from '../../contexts/NotificationsProvider';
import RemoveForm from '../RemoveForm';

export default function (props) {
    const [isLoading, setLoading] = useState(false);
    const [isAuthorized, setAuthorized] = useState(false);

    const notifications = useContext(NotificationsContext);
    const navigate = useNavigate();

    useEffect(() => {
        authorize(notifications, setAuthorized, 'isAdmin');
    }, []);

    const onSubmit = (event) => {
        remove(notifications, navigate, setLoading, props.id);
    };

    if (isAuthorized) {
        return <RemoveForm onSubmit={onSubmit} isLoading={isLoading} />;
    }

    return null;
}
