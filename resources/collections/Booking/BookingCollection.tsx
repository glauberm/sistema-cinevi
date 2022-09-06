import React, { useContext, useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import FullCalendar from '@fullcalendar/react';
import dayGridPlugin from '@fullcalendar/daygrid';
import ptBrLocale from '@fullcalendar/core/locales/pt-br';
import dayjs from 'dayjs';
import 'dayjs/locale/pt-br';

import routes from '../../routes/booking';
import { showBetween } from '../../requests/booking';
import { NotificationsContext } from '../../contexts/NotificationsProvider';
import { ApiContext } from '../../contexts/ApiProvider';

export default function BookingCollection() {
    const [startDate, setStartDate] = useState(null);
    const [endDate, setEndDate] = useState(null);
    const [events, setEvents] = useState([]);
    const [data, setData] = useState([]);
    const [loading, setLoading] = useState(false);
    const [loadingNotification, setLoadingNotification] = useState(null);
    const notifications = useContext(NotificationsContext);
    const apiProvider = useContext(ApiContext);
    const navigate = useNavigate();

    useEffect(() => {
        if (startDate !== null && endDate !== null) {
            showBetween(
                apiProvider.api,
                notifications,
                setData,
                setLoading,
                dayjs(startDate).format('YYYY-MM-DD'),
                dayjs(endDate).format('YYYY-MM-DD')
            );
        }
    }, [startDate, endDate]);

    useEffect(() => {
        if (loading === true) {
            setLoadingNotification(notifications.add('Carregando...'));
        } else if (loadingNotification !== null) {
            notifications.remove(loadingNotification.id);

            setLoadingNotification(null);
        }
    }, [loading]);

    useEffect(() => {
        setEvents(
            data.map((date) => {
                return {
                    title: `#${date.id} - ${date.owner.name}`,
                    start: dayjs(date.withdrawal_date)
                        .set('hour', 0)
                        .set('minute', 0)
                        .set('second', 0)
                        .format('YYYY-MM-DD HH:mm:ss'),
                    end: dayjs(date.devolution_date)
                        .set('hour', 23)
                        .set('minute', 59)
                        .set('second', 59)
                        .format('YYYY-MM-DD HH:mm:ss'),
                    url: routes.update.getPath(date.id),
                };
            })
        );
    }, [data]);

    return (
        <div className="BookingCollection">
            <FullCalendar
                plugins={[dayGridPlugin]}
                initialView="dayGridMonth"
                locale={ptBrLocale}
                height="auto"
                events={events}
                eventBackgroundColor="#cce1e7"
                eventBorderColor="#99c3d0"
                eventTextColor="#212529"
                displayEventTime={false}
                datesSet={(dates) => {
                    setStartDate(dates.start);
                    setEndDate(dates.end);
                }}
                eventClick={(event) => {
                    event.jsEvent.preventDefault();

                    document.querySelectorAll(`a[href="${event.el.getAttribute('href')}"]`).forEach((el) => {
                        el.classList.add('active');
                    });

                    if (event.el instanceof HTMLAnchorElement) {
                        navigate(event.el.pathname);
                    }
                }}
                eventMouseEnter={(event) => {
                    document.querySelectorAll(`a[href="${event.el.getAttribute('href')}"]`).forEach((el) => {
                        el.classList.add('hover');
                    });
                }}
                eventMouseLeave={(event) => {
                    document.querySelectorAll(`a[href="${event.el.getAttribute('href')}"]`).forEach((el) => {
                        el.classList.remove('hover');
                    });
                }}
            />
        </div>
    );
}
