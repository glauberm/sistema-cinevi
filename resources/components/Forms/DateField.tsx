import React, { useEffect, useState } from 'react';
import dayjs from 'dayjs';
import 'dayjs/locale/pt-br';

const currentYear = dayjs().year();
const currentMonth = dayjs().month() + 1;
const currentDay = dayjs().date();

export default function DateField(props) {
    const { name, label, values, errors, touched, onChange } = props;

    const [year, setYear] = useState(currentYear.toString());
    const [month, setMonth] = useState(currentMonth.toString().padStart(2, '0'));
    const [day, setDay] = useState(currentDay.toString().padStart(2, '0'));
    const [daysOptions, setDaysOptions] = useState([]);

    const setYearValue = ({ target }) => {
        onChange(`${target.value}-${month}-${day}`);
    };

    const setMonthValue = ({ target }) => {
        onChange(`${year}-${target.value}-${day}`);
    };

    const setDayValue = ({ target }) => {
        onChange(`${year}-${month}-${target.value}`);
    };

    useEffect(() => {
        if (values !== null) {
            const date = dayjs(values);

            setYear(date.year().toString());
            setMonth((date.month() + 1).toString().padStart(2, '0'));
            setDay(date.date().toString().padStart(2, '0'));
        }
    }, [values]);

    useEffect(() => {
        const options = [];
        let maxDays;

        const isLeapYear = (year) => {
            return (year % 4 == 0 && year % 100 != 0) || year % 400 == 0;
        };

        switch (month) {
            case '02':
                maxDays = isLeapYear(year) ? 29 : 28;
                break;
            case '04':
            case '06':
            case '09':
            case '11':
                maxDays = 30;
                break;
            default:
                maxDays = 31;
                break;
        }

        for (let i = 1; i <= maxDays; i++) {
            options.push(i.toString().padStart(2, '0'));
        }

        return setDaysOptions(options);
    }, [year, month]);

    return (
        <div className="mb-4">
            <label htmlFor={name} className="form-label">
                {label}
            </label>

            <div className="row mb-2">
                <label htmlFor={`${name}-year`} className="col-sm-2 col-form-label col-form-label-sm">
                    Ano
                </label>

                <div className="col-sm-10">
                    <select
                        id={`${name}-year`}
                        name={`${name}-year`}
                        className={`form-select form-select-sm ${errors && touched ? 'is-invalid' : ''}`}
                        value={year}
                        onChange={setYearValue}
                    >
                        <option value={currentYear}>{currentYear}</option>
                        <option value={currentYear + 1}>{currentYear + 1}</option>
                        <option value={currentYear + 2}>{currentYear + 2}</option>
                    </select>
                </div>
            </div>

            <div className="row mb-2">
                <label htmlFor={`${name}-month`} className="col-sm-2 col-form-label col-form-label-sm">
                    Mês
                </label>

                <div className="col-sm-10">
                    <select
                        id={`${name}-month`}
                        name={`${name}-month`}
                        className={`form-select form-select-sm ${errors && touched ? 'is-invalid' : ''}`}
                        value={month}
                        onChange={setMonthValue}
                    >
                        <option value="01">Janeiro</option>
                        <option value="02">Fevereiro</option>
                        <option value="03">Março</option>
                        <option value="04">Abril</option>
                        <option value="05">Maio</option>
                        <option value="06">Junho</option>
                        <option value="07">Julho</option>
                        <option value="08">Agosto</option>
                        <option value="09">Setembro</option>
                        <option value="10">Outubro</option>
                        <option value="11">Novembro</option>
                        <option value="12">Dezembro</option>
                    </select>
                </div>
            </div>

            <div className="row mb-2">
                <label htmlFor={`${name}-day`} className="col-sm-2 col-form-label col-form-label-sm">
                    Dia
                </label>

                <div className="col-sm-10">
                    <select
                        id={`${name}-day`}
                        name={`${name}-day`}
                        className={`form-select form-select-sm ${errors && touched ? 'is-invalid' : ''}`}
                        value={day}
                        disabled={!Boolean(month)}
                        onChange={setDayValue}
                    >
                        {daysOptions.map((option, key) => (
                            <option key={key} value={option}>
                                {option}
                            </option>
                        ))}
                    </select>
                </div>
            </div>

            {errors && touched && <div className="invalid-feedback">{errors}</div>}
        </div>
    );
}

DateField.defaultProps = {
    values: null,
};
