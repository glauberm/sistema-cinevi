import React, { createContext, ReactElement, useState } from 'react';

import Notification from '../components/Notification';

export interface NotificationsContextInterface {
    add: (content: string, status?: string) => void;
    remove: (id: number) => void;
}

export const NotificationsContext = createContext<NotificationsContextInterface | undefined>(undefined);

interface NotificationInterface {
    id: number;
    content: string;
    status: string;
}

interface NotificationProviderProps {
    children: ReactElement;
}

export default function NotificationsProvider(props: NotificationProviderProps) {
    const [id, setId] = useState<number>(0);
    const [notifications, setNotifications] = useState<NotificationInterface[]>([]);

    const add = (content: string, status: string = 'info') => {
        const newNotification: NotificationInterface = { id: id, content: content, status: status };
        setNotifications([...notifications, newNotification]);
        setId(id + 1);
    };

    const remove = (id: number) => {
        setNotifications(notifications.filter((notification: NotificationInterface) => notification.id !== id));
    };

    const contextValues: NotificationsContextInterface = { add: add, remove: remove };

    return (
        <NotificationsContext.Provider value={contextValues}>
            {props.children}

            {Boolean(notifications.length) && (
                <div className="NotificationsProvider" aria-live="polite" aria-atomic="true">
                    {notifications.map(({ id, content, status }) => (
                        <Notification key={id} content={content} status={status} handleDismiss={() => remove(id)} />
                    ))}
                </div>
            )}
        </NotificationsContext.Provider>
    );
}
