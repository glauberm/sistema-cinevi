import React, { useEffect, useState } from 'react';

import Checkbox from './Checkbox';

export default function CheckboxGroupField(props) {
    const { name, label, items, errors, touched, messages, selected: selectedProps, onChange } = props;
    const [selected, setSelected] = useState([]);

    const select = (itemValue) => {
        if (Boolean(selected.length)) {
            selected.some((value) => value === itemValue)
                ? onChange(selected.filter((value) => value !== itemValue))
                : onChange([...selected, itemValue]);
        } else {
            onChange([itemValue]);
        }
    };

    useEffect(() => {
        if (selectedProps !== null) {
            setSelected(selectedProps);
        }
    }, [selectedProps]);

    return (
        <div className="mb-4">
            <label htmlFor={`${name}-group`} id={`${name}-group-label`} className="form-label">
                {label}
            </label>
            <div
                role="group"
                id={`${name}-group`}
                aria-labelledby={`${name}-group-label`}
                className={errors && touched ? 'is-invalid' : ''}
            >
                {items.map((item, key) => (
                    <Checkbox
                        key={key}
                        name={`${name}-${key}`}
                        label={item.label}
                        errors={errors}
                        touched={touched}
                        checked={selected.includes(item.value)}
                        onChange={() => select(item.value)}
                    />
                ))}
            </div>

            {errors && touched && <div className="invalid-feedback">{errors}</div>}

            {messages &&
                messages.map((message, key) => (
                    <p key={key} className="text-muted lh-1 mt-1 mb-1">
                        <small>{message}</small>
                    </p>
                ))}
        </div>
    );
}

CheckboxGroupField.defaultProps = {
    selected: [],
};
