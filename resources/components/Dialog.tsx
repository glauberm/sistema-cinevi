import React, { useEffect, useRef, useState } from 'react';

export default function (props) {
    const [focusableEls, setFocusableEls] = useState([]);
    const [firstFocusableEl, setFirstFocusableEl] = useState(null);
    const [lastFocusableEl, setLastFocusableEl] = useState(null);
    const dialogRef = useRef(null);

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

        if (dialogRef.current !== null && focusableEls.length === 0) {
            setFocusableEls(
                dialogRef.current.querySelectorAll(`
                    a[href],
                    input:not([disabled]),
                    select:not([disabled]),
                    textarea:not([disabled]),
                    button:not([disabled]),
                    [tabindex="0"]
                `)
            );
        }

        if (focusableEls.length > 0 && firstFocusableEl === null && lastFocusableEl === null) {
            console.log('a');
            setFirstFocusableEl(focusableEls[0]);
            setLastFocusableEl(focusableEls[focusableEls.length - 1]);
        }

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
    }, [dialogRef, firstFocusableEl, lastFocusableEl]);

    useEffect(() => {
        document.addEventListener('keydown', handleKeyDown);

        if (dialogRef.current !== null && focusableEls.length === 0) {
            setFocusableEls(
                dialogRef.current.querySelectorAll(`
                    a[href],
                    input:not([disabled]),
                    select:not([disabled]),
                    textarea:not([disabled]),
                    button:not([disabled]),
                    [tabindex="0"]
                `)
            );
        }

        if (focusableEls.length > 0 && firstFocusableEl === null && lastFocusableEl === null) {
            console.log('a');
            setFirstFocusableEl(focusableEls[0]);
            setLastFocusableEl(focusableEls[focusableEls.length - 1]);
        }

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
    }, [dialogRef, focusableEls, firstFocusableEl, lastFocusableEl]);

    return (
        <div
            ref={dialogRef}
            className="modal"
            tabIndex={-1}
            aria-labelledby={`Dialog__title--${props.id}`}
            aria-hidden="true"
            style={{ display: 'block' }}
        >
            <div className="modal-dialog modal-dialog-centered">
                <div className="modal-content">
                    <div className="modal-header">
                        <h1 className="modal-title h5" id={`Dialog__title--${props.id}`}>
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
