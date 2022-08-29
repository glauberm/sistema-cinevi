import React from 'react';
import Datetime from 'react-datetime';
import moment from 'moment';
import 'moment/locale/pt-br';

moment.locale('pt-br');

const DATE_FORMAT = 'DD/MM/YYYY';

export default function (props) {
    // onChange = (value) => {
    //     let datetimeValue = value;

    //     if (value instanceof moment) {
    //         datetimeValue = moment(value).format(`${DATE_FORMAT}`);
    //     }

    //     props.form.setFieldValue(props.field.name, datetimeValue);
    // };

    // onFocus = () => {
    //     if (!Boolean(field.value)) {
    //         props.form.setFieldValue(props.field.name, moment(new Date()).format(`${DATE_FORMAT}`));
    //     }
    // };

    // onBlur = () => {
    //     props.form.setFieldTouched(props.field.name, true);
    // };

    return (
        <Datetime
            dateFormat={DATE_FORMAT}
            timeFormat={false}
            // id={field.name}
            // name={field.name}
            // value={field.value}
            // onChange={onChange}
            // onOpen={onFocus}
            // onClose={onBlur}
            closeOnSelect
            // className={`${form.errors[field.name] && form.touched[field.name] ? ' is-danger' : ''}`}
            // inputProps={{
            //     id: field.name,
            // }}
        />
    );
}
