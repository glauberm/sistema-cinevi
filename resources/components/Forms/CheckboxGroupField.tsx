import React, { useEffect, useState } from 'react';

import Checkbox from './Checkbox';

export default function CheckboxGroupField(props) {
    const { name, label, items, selected: selectedProps, onChange } = props;
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
        <div>
            <label id={`${name}-group`} className="form-label">
                {label}
            </label>
            <div role="group" aria-labelledby={`${name}-group`} className="mb-4">
                {items.map((item, key) => (
                    <Checkbox
                        key={key}
                        name={`${name}-${key}`}
                        label={item.label}
                        checked={selected.includes(item.value)}
                        size="sm"
                        onChange={() => select(item.value)}
                    />
                ))}
            </div>
        </div>
    );
}

CheckboxGroupField.defaultProps = {
    selected: [],
};
