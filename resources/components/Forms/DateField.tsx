import React, { useEffect, useRef, useState } from 'react';
import FullCalendar from '@fullcalendar/react';
import dayGridPlugin from '@fullcalendar/daygrid';
import ptBrLocale from '@fullcalendar/core/locales/pt-br';
import dayjs from 'dayjs';
import 'dayjs/locale/pt-br';

export default function DateField(props) {
    const { name, label, values, errors, touched, onChange } = props;

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
                    className="form-control"
                    onFocus={openDialog}
                    onBlur={closeDialog}
                />

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
                                weekends={false}
                                initialDate={values || null}
                                validRange={(nowDate) => ({
                                    start: dayjs(nowDate).add(3, 'day').format('YYYY-MM-DD'),
                                })}
                                navLinks={true}
                                navLinkDayClick={(date, jsEvent) => {
                                    jsEvent.preventDefault();
                                    select(date);
                                }}
                            />
                        </div>
                    </div>
                )}

                {errors && touched && <div className="invalid-feedback">{errors}</div>}
            </div>
        </div>
    );
}

DateField.defaultProps = {
    values: null,
};
