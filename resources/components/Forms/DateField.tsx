import React, { useEffect, useRef, useState } from 'react';
import FullCalendar from '@fullcalendar/react';
import dayGridPlugin from '@fullcalendar/daygrid';
import ptBrLocale from '@fullcalendar/core/locales/pt-br';
import dayjs from 'dayjs';
import 'dayjs/locale/pt-br';

export default function DateField(props) {
    const { name, label, values, errors, touched, messages, onChange, weekends, validRange } = props;

    const [isDialogOpen, setIsDialogOpen] = useState(false);
    const selectRef = useRef(null);

    const select = (date) => {
        onChange(dayjs(date).format('YYYY-MM-DD'));
        setIsDialogOpen(false);
    };

    const openDialog = () => {
        setIsDialogOpen(true);
    };

    const closeDialog = ({ target }) => {
        if (selectRef.current !== null && !selectRef.current.contains(target)) {
            setIsDialogOpen(false);
        }
    };

    useEffect(() => {
        document.addEventListener('mousedown', closeDialog);
        document.addEventListener('focusin', closeDialog);

        return () => {
            document.removeEventListener('mousedown', closeDialog);
            document.removeEventListener('focusin', closeDialog);
        };
    }, []);

    return (
        <div className="mb-4 DateField">
            <label htmlFor={name} className="form-label">
                {label}
            </label>

            <div ref={selectRef}>
                <input
                    id={name}
                    name={name}
                    type="text"
                    readOnly
                    value={values}
                    className={`form-control ${errors && touched ? 'is-invalid' : ''}`}
                    onFocus={openDialog}
                    onBlur={closeDialog}
                />

                {errors && touched && <div className="invalid-feedback">{errors}</div>}

                {messages &&
                    messages.map((message, key) => (
                        <p key={key} className="text-muted lh-1 mt-1 mb-1">
                            <small>{message}</small>
                        </p>
                    ))}

                {isDialogOpen && (
                    <div className="position-absolute shadow p-3 mt-1 mb-5 bg-body rounded">
                        <div className="DateField__calendar">
                            <FullCalendar
                                plugins={[dayGridPlugin]}
                                initialView="dayGridMonth"
                                locale={ptBrLocale}
                                height="auto"
                                headerToolbar={{
                                    start: 'title',
                                    center: '',
                                    end: 'prev,next',
                                }}
                                initialDate={values || null}
                                weekends={weekends}
                                validRange={validRange}
                                navLinks={true}
                                navLinkDayClick={(date, jsEvent) => {
                                    jsEvent.preventDefault();
                                    select(date);
                                }}
                            />
                        </div>
                    </div>
                )}
            </div>
        </div>
    );
}

DateField.defaultProps = {
    values: null,
};
