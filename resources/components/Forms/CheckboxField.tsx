import React from 'react';
import { Field as FormikField } from 'formik';
import { FastField as FormikFastField } from 'formik';

import Checkbox from './Checkbox';

export default function (props) {
    const { name, label, errors, touched, isFastField } = props;

    const componentFn = ({ field, form }) => (
        <Checkbox
            id={field.name}
            label={label}
            name={field.name}
            value={field.value}
            onChange={(e) => {
                form.setFieldValue(field.name, e.target.checked);
            }}
            errors={errors}
            touched={touched}
        />
    );

    return isFastField ? (
        <FormikFastField id={name} name={name}>
            {componentFn}
        </FormikFastField>
    ) : (
        <FormikField id={name} name={name}>
            {componentFn}
        </FormikField>
    );
}
