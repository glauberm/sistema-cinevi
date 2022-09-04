import React, { createContext, ReactElement, useState } from 'react';

import Notification from '../components/Notification';

export type NotificationsContextInterface = {
    add: (content: string, status?: string) => void;
    remove: (id: number) => void;
};

export const NotificationsContext = createContext<NotificationsContextInterface | undefined>(undefined);

type NotificationInterface = {
    id: number;
    content: string;
    status: string;
    hasExtendedTime: boolean;
};

type NotificationProviderProps = {
    children: ReactElement;
};

export default function NotificationsProvider(props: NotificationProviderProps) {
    const [id, setId] = useState<number>(0);
    const [notifications, setNotifications] = useState<NotificationInterface[]>([]);

    const add = (content: string, status: string = 'info', hasExtendedTime: boolean = false) => {
        const newNotification: NotificationInterface = { id, content, status, hasExtendedTime };

        setNotifications([...notifications, newNotification]);
        setId(id + 1);

        return newNotification;
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
                    {notifications.map(({ id, content, status, hasExtendedTime }) => (
                        <Notification
                            key={id}
                            content={content}
                            status={status}
                            hasExtendedTime={hasExtendedTime}
                            handleDismiss={() => remove(id)}
                        />
                    ))}
                </div>
            )}
        </NotificationsContext.Provider>
    );
}
