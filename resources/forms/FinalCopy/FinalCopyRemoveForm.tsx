import React, { useContext, useState } from 'react';
import { useNavigate } from 'react-router-dom';

import { remove } from '../../requests/final-copy';
import { NotificationsContext } from '../../contexts/NotificationsProvider';
import { ApiContext } from '../../contexts/ApiProvider';
import { AuthContext } from '../../contexts/AuthProvider';
import RemoveForm from '../RemoveForm';

export default function FinalCopyRemoveForm(props) {
    const [isLoading, setLoading] = useState(false);

    const notifications = useContext(NotificationsContext);
    const apiProvider = useContext(ApiContext);
    const authProvider = useContext(AuthContext);
    const navigate = useNavigate();

    const onSubmit = () => {
        remove(apiProvider.api, notifications, navigate, setLoading, props.id);
    };

    if (authProvider.hasRole('admin')) {
        return <RemoveForm onSubmit={onSubmit} isLoading={isLoading} />;
    }

    return null;
}
