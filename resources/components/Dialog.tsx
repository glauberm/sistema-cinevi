import React, { useEffect, useRef, useState } from 'react';

export default function Dialog(props) {
    const dialogRef = useRef(null);

    const [focusableEls, setFocusableEls] = useState([]);
    const [firstFocusableEl, setFirstFocusableEl] = useState(null);
    const [lastFocusableEl, setLastFocusableEl] = useState(null);

    const handleKeyDown = (event) => {
        const KEY_TAB = 9;
        const KEY_ESC = 27;

        const handleBackwardTab = () => {
            if (document.activeElement === firstFocusableEl) {
                event.preventDefault();

                lastFocusableEl.focus();
            }
        };

        const handleForwardTab = () => {
            if (document.activeElement === lastFocusableEl) {
                event.preventDefault();

                firstFocusableEl.focus();
            }
        };

        switch (event.keyCode) {
            case KEY_TAB:
                if (focusableEls.length === 1) {
                    event.preventDefault();
                    break;
                }

                if (event.shiftKey) {
                    handleBackwardTab();
                } else {
                    handleForwardTab();
                }

                break;
            case KEY_ESC:
                props.close();

                event.stopPropagation();

                break;
            default:
                break;
        }
    };

    useEffect(() => {
        document.addEventListener('keydown', handleKeyDown);

        setFocusableEls(
            dialogRef.current.querySelectorAll(`
                a[href],
                area[href],
                input:not([disabled]),
                select:not([disabled]),
                textarea:not([disabled]),
                button:not([disabled]),
                [tabindex="0"]
            `)
        );

        setFirstFocusableEl(focusableEls[0]);

        setLastFocusableEl(focusableEls[focusableEls.length - 1]);

        const focusedElementBeforeOpen = document.activeElement;

        if (firstFocusableEl !== null) {
            firstFocusableEl.focus();
        }

        return () => {
            if (focusedElementBeforeOpen instanceof HTMLElement) {
                focusedElementBeforeOpen.focus();
            }

            document.removeEventListener('keydown', handleKeyDown);
        };
    }, []);

    return (
        <div
            ref={dialogRef}
            className="modal"
            tabIndex={-1}
            aria-labelledby={`Dialog__title--${props.key}`}
            aria-hidden="true"
            style={{ display: 'block' }}
        >
            <div className="modal-dialog modal-dialog-centered">
                <div className="modal-content">
                    <div className="modal-header">
                        <h1 className="modal-title h5" id={`Dialog__title--${props.key}`}>
                            {props.title}
                        </h1>
                        <button type="button" className="btn-close" aria-label="Fechar" onClick={props.close} />
                    </div>

                    <div className="modal-body">{props.body}</div>

                    <div className="modal-footer">{props.footer}</div>
                </div>
            </div>
        </div>
    );
}
