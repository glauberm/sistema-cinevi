import React, { useState, useContext } from 'react';
import { useNavigate } from 'react-router-dom';
import { Formik } from 'formik';
import * as Yup from 'yup';

import { requestResetPassword } from '../../requests/authentication';
import { NotificationsContext } from '../../contexts/NotificationsProvider';
import { ApiContext } from '../../contexts/ApiProvider';
import Form from '../../components/Forms/Form';
import Field from '../../components/Forms/Field';
import Button from '../../components/Button';

const initialValues = {
    email: '',
};

const validationSchema = Yup.object({
    email: Yup.string().required('Campo obrigatório').email('Endereço de email inválido'),
});

export default function AuthenticationRequestResetPasswordForm(props) {
    const [isLoading, setLoading] = useState(false);
    const notifications = useContext(NotificationsContext);
    const apiProvider = useContext(ApiContext);
    const navigate = useNavigate();

    const onSubmit = (values) => {
        requestResetPassword(apiProvider.api, notifications, navigate, setLoading, values);
    };

    return (
        <Formik initialValues={initialValues} validationSchema={validationSchema} onSubmit={onSubmit}>
            {({ errors, touched }) => (
                <Form>
                    <Field name="email" label="Email" type="email" errors={errors.email} touched={touched.email} />
                    <div className="d-grid gap-2">
                        <Button type="submit" className="btn btn-lg btn-primary" isLoading={isLoading}>
                            Recuperar senha
                        </Button>
                    </div>
                </Form>
            )}
        </Formik>
    );
}
