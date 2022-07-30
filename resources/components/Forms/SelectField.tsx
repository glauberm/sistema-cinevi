import React from 'react';
import { Field as FormikField } from 'formik';
import { FastField as FormikFastField } from 'formik';

import Select from './Select';

export default function SelectField(props) {
    const { name, label, labelHidden, errors, touched, children, isLoading, withAddOn, isFastField } = props;

    const componentFn = ({ field }) => (
        <Select
            label={label}
            labelHidden={labelHidden}
            name={field.name}
            value={field.value}
            errors={errors}
            touched={touched}
            onChange={field.onChange}
            isLoading={isLoading}
            withAddOn={withAddOn}
        >
            {children}
        </Select>
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
