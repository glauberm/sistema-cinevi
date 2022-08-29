import React from 'react';

import Field from './Field';
import DateTime from './DateTime';

export default function (props) {
    const { name, label, errors, touched } = props;

    return <Field name={name} label={label} component={DateTime} errors={errors} touched={touched} />;
}
