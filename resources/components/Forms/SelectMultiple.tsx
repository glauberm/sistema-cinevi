import React, { useEffect, useRef, useState } from 'react';

import Button from '../Button';
import Checkbox from './Checkbox';

export default function SelectMultiple(props) {
    const {
        name,
        label,
        multipleLabel,
        addLabel,
        selected: selectedProps,
        onChange,
        errors,
        touched,
        children,
    } = props;

    const [selected, setSelected] = useState([]);
    const [isDialogOpen, setIsDialogOpen] = useState(false);
    const selectRef = useRef(null);

    const select = (item) => {
        if (Boolean(selected.length)) {
            selected.some((el) => el.id === item.id)
                ? onChange(selected.filter((el) => el.id !== item.id))
                : onChange([...selected, item]);
        } else {
            onChange([item]);
        }
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

    useEffect(() => {
        if (Boolean(selectedProps.length)) {
            setSelected(selectedProps);
        }
    }, [selectedProps]);

    return (
        <div className="mb-4">
            <label htmlFor={name} className="form-label">
                {label}
            </label>

            {Boolean(selected.length) && (
                <div className="mb-3">
                    {selected.map((item, key) => (
                        <Checkbox
                            key={key}
                            checked
                            label={multipleLabel(item)}
                            name={`${name}-${key}`}
                            size="sm"
                            onChange={() => setSelected(selected.filter((el) => el.id !== item.id))}
                        />
                    ))}
                </div>
            )}

            <div>
                <span ref={selectRef}>
                    <Button
                        type="button"
                        name={name}
                        className="btn-secondary btn-sm"
                        onClick={openDialog}
                        onBlur={closeDialog}
                    >
                        {addLabel}
                    </Button>

                    {isDialogOpen && (
                        <div className="position-absolute shadow p-3 mt-1 mb-5 bg-body rounded">
                            {children(selected, select)}
                        </div>
                    )}
                </span>
            </div>

            {errors && touched && <div className="invalid-feedback">{errors}</div>}
        </div>
    );
}

SelectMultiple.defaultProps = {
    selected: [],
};
