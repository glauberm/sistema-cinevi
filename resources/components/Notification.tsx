import React, { useEffect, useState } from 'react';

export default function (props) {
    const { status, handleDismiss, content } = props;
    const [isActive, setActive] = useState(true);
    const [isSlidingOut, setSlidingOut] = useState(false);

    useEffect(() => {
        let timeoutSlideOut, timeoutDismiss;

        const slideOut = () => {
            setActive(false);
            setSlidingOut(true);
            clearTimeout(timeoutSlideOut);
        };

        const dismiss = () => {
            setSlidingOut(false);
            handleDismiss();
            clearTimeout(timeoutDismiss);
        };

        if (!timeoutSlideOut && isActive === true) {
            timeoutSlideOut = setTimeout(slideOut, 5000);
        }

        if (!timeoutDismiss && isActive === false) {
            timeoutDismiss = setTimeout(dismiss, 250);
        }

        return () => {
            clearTimeout(timeoutSlideOut);
            clearTimeout(timeoutDismiss);
        };
    }, [isActive]);

    return (
        <div
            className={`Notification bg-gradient shadow alert alert-dismissible alert-${status || 'info'}
                ${isActive ? 'Notification--active' : ''}
                ${isSlidingOut ? 'Notification--slide-out' : ''}
            `}
            role="alert"
            aria-live="assertive"
            aria-atomic="true"
        >
            {content}
            <button type="button" className="btn-close" aria-label="Fechar" onClick={handleDismiss} />
        </div>
    );
}
