import React, { useState, useContext } from 'react';
import { useNavigate } from 'react-router-dom';
import { Formik } from 'formik';
import * as Yup from 'yup';

import { login } from '../../requests/authentication';
import { NotificationsContext } from '../../contexts/NotificationsProvider';
import Form from '../../components/Forms/Form';
import Field from '../../components/Forms/Field';
import Button from '../../components/Button';

const initialValues = {
    email: '',
    phone: '',
    identifier: '',
    password: '',
};

const validationSchema = Yup.object({
    email: Yup.string().required('Campo obrigatório').email('Endereço de e-mail inválido'),
    phone: Yup.string().required('Campo obrigatório'),
    identifier: Yup.string().required('Campo obrigatório'),
    password: Yup.string().required('Campo obrigatório').min(8, 'A senha deve ter no mínimo 8 caracteres'),
});

export default function (props) {
    const [isLoading, setLoading] = useState(false);
    const notifications = useContext(NotificationsContext);
    const navigate = useNavigate();

    const onSubmit = (values) => {
        // login(values, notifications, navigate, setLoading);
        notifications.add('Os cadastros estão fechados no momento.', 'warning');
    };

    return (
        <Formik initialValues={initialValues} validationSchema={validationSchema} onSubmit={onSubmit}>
            {({ errors, touched }) => (
                <Form>
                    <Field
                        name="name"
                        label="Nome completo"
                        type="text"
                        autoComplete="name"
                        errors={errors.name}
                        touched={touched.name}
                    />
                    <Field
                        name="email"
                        label="E-mail"
                        type="email"
                        autoComplete="email"
                        errors={errors.email}
                        touched={touched.email}
                    />
                    <Field name="phone" label="Telefone" type="tel" errors={errors.phone} touched={touched.phone} />
                    <Field
                        name="identifier"
                        label="Matrícula ou SIAPE"
                        type="text"
                        errors={errors.identifier}
                        touched={touched.identifier}
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
                            Cadastrar
                        </Button>
                    </div>
                </Form>
            )}
        </Formik>
    );
}
