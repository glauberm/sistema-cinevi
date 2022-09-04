import React, { useState, useContext, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { Formik } from 'formik';
import * as Yup from 'yup';

import authentication from '../../routes/authentication';
import { resetPassword } from '../../requests/authentication';
import { NotificationsContext } from '../../contexts/NotificationsProvider';
import { ApiContext } from '../../contexts/ApiProvider';
import Form from '../../components/Forms/Form';
import Field from '../../components/Forms/Field';
import Button from '../../components/Button';

const initialValues = {
    password: '',
    password_confirmation: '',
};

const validationSchema = Yup.object({
    password: Yup.string()
        .required('Campo obrigatório')
        .matches(/^.*(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/, 'Deve conter maiúsculas, minúsculas e números')
        .min(8, 'A senha deve ter no mínimo 8 caracteres'),
    password_confirmation: Yup.string()
        .oneOf([Yup.ref('password'), null], 'As senhas não coincidem')
        .required('Campo obrigatório'),
});

export default function AuthenticationResetPasswordForm(props) {
    const [isLoading, setLoading] = useState(false);
    const notifications = useContext(NotificationsContext);
    const apiProvider = useContext(ApiContext);
    const navigate = useNavigate();

    const onSubmit = (values) => {
        const urlSearchParams = new URLSearchParams(location.search);
        const url = urlSearchParams.get('url');

        if (url) {
            resetPassword(apiProvider.api, notifications, navigate, setLoading, url, values);
        }
    };

    useEffect(() => {
        const urlSearchParams = new URLSearchParams(location.search);
        const url = urlSearchParams.get('url');

        if (!url) {
            notifications.add('A URL está malformatada. Por favor, tente novamente.');
            navigate(authentication.login.path);
        }
    }, [location.search]);

    return (
        <Formik initialValues={initialValues} validationSchema={validationSchema} onSubmit={onSubmit}>
            {({ errors, touched }) => (
                <Form>
                    <Field
                        name="password"
                        label="Senha"
                        type="password"
                        errors={errors.password}
                        touched={touched.password}
                        messages={['Maiúsculas, minúsculas e números', 'Mínimo 8 caracteres']}
                    />
                    <Field
                        name="password_confirmation"
                        label="Confirmar senha"
                        type="password"
                        errors={errors.password_confirmation}
                        touched={touched.password_confirmation}
                    />

                    <div className="d-grid gap-2">
                        <Button type="submit" className="btn btn-lg btn-primary" isLoading={isLoading}>
                            Redefinir senha
                        </Button>
                    </div>
                </Form>
            )}
        </Formik>
    );
}
