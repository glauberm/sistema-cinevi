import React, { useState, useContext } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { Formik } from 'formik';
import * as Yup from 'yup';

import authentication from '../../routes/authentication';
import { login } from '../../requests/authentication';
import { NotificationsContext } from '../../contexts/NotificationsProvider';
import { ApiContext } from '../../contexts/ApiProvider';
import { AuthContext } from '../../contexts/AuthProvider';
import Form from '../../components/Forms/Form';
import Field from '../../components/Forms/Field';
import Button from '../../components/Button';

const initialValues = {
    email: '',
    password: '',
};

const validationSchema = Yup.object({
    email: Yup.string().required('Campo obrigatório').email('Endereço de e-mail inválido'),
    password: Yup.string().required('Campo obrigatório'),
});

export default function AuthenticationLoginForm() {
    const [isLoading, setLoading] = useState(false);
    const notifications = useContext(NotificationsContext);
    const apiProvider = useContext(ApiContext);
    const authProvider = useContext(AuthContext);
    const navigate = useNavigate();

    const onSubmit = (values) => {
        login(apiProvider.api, authProvider, values, notifications, navigate, setLoading);
    };

    return (
        <Formik initialValues={initialValues} validationSchema={validationSchema} onSubmit={onSubmit}>
            {({ errors, touched }) => (
                <Form>
                    <Field
                        name="email"
                        label="E-mail"
                        type="email"
                        autoComplete="email"
                        errors={errors.email}
                        touched={touched.email}
                    />
                    <Field
                        name="password"
                        label="Senha"
                        type="password"
                        errors={errors.password}
                        touched={touched.password}
                    />
                    <div className="d-grid gap-2">
                        <Button type="submit" className="btn btn-lg btn-primary" isLoading={isLoading}>
                            Entrar
                        </Button>
                    </div>
                    <hr />
                    <div className="text-center">
                        <Link to={authentication.requestReset.path} className="btn btn-link">
                            Recuperação de senha
                        </Link>
                    </div>
                </Form>
            )}
        </Formik>
    );
}
