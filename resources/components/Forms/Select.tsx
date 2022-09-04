import React, { useEffect, useRef, useState } from 'react';

export default function Select(props) {
    const {
        name,
        label,
        size,
        value,
        placeholder,
        selected: selectedProps,
        onChange,
        errors,
        touched,
        children,
    } = props;

    const [selected, setSelected] = useState(null);
    const [isDialogOpen, setIsDialogOpen] = useState(false);
    const selectRef = useRef(null);

    const select = (item) => {
        onChange(item);
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

    useEffect(() => {
        if (selectedProps !== null) {
            setSelected(selectedProps);
        }
    }, [selectedProps]);

    return (
        <div className="mb-4">
            <label htmlFor={name} className="form-label">
                {label}
            </label>

            <div ref={selectRef}>
                <input
                    id={name}
                    name={name}
                    type="text"
                    value={value || ''}
                    placeholder={placeholder || ''}
                    readOnly
                    className={`
                    form-select Field
                    ${size === 'lg' ? 'form-control-lg' : ''}
                    ${errors && touched ? 'is-invalid' : ''}
                `}
                    onFocus={openDialog}
                    onBlur={closeDialog}
                />

                {isDialogOpen && (
                    <div className="position-absolute shadow p-3 mt-1 mb-5 bg-body rounded">
                        {children(selected, select)}
                    </div>
                )}
            </div>

            {errors && touched && <div className="invalid-feedback">{errors}</div>}
        </div>
    );
}

Select.defaultProps = {
    selected: null,
};
