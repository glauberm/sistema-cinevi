import React, { useState, useContext, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { FieldArray, Formik } from 'formik';
import * as Yup from 'yup';

import { show, update } from '../../requests/configuration';
import { NotificationsContext } from '../../contexts/NotificationsProvider';
import { ApiContext } from '../../contexts/ApiProvider';
import Form from '../../components/Forms/Form';
import Field from '../../components/Forms/Field';
import Button from '../../components/Button';
import Section from '../../components/Section';
import CheckboxField from '../../components/Forms/CheckboxField';
import MonthAndDayField, { emptyValue } from '../../components/Forms/MonthAndDayField';

const initialValues = {
    bookings_are_closed: false,
    bookings_forbidden_dates: [],
    final_copies_confirmation_message: '',
};

const validationSchema = Yup.object({
    // bookings_closed: Yup.bool().required('Campo obrigatório'),
});

export default function ConfigurationUpdateForm(props) {
    const [isLoading, setLoading] = useState(false);
    const [values, setValues] = useState(initialValues);

    const notifications = useContext(NotificationsContext);
    const apiProvider = useContext(ApiContext);
    const navigate = useNavigate();

    const onSubmit = (values) => {
        update(apiProvider.api, notifications, navigate, setLoading, values, { navigateTo: '/' });
    };

    useEffect(() => {
        show(apiProvider.api, notifications, setValues, setLoading);
    }, []);

    return (
        <Formik enableReinitialize initialValues={values} validationSchema={validationSchema} onSubmit={onSubmit}>
            {({ values, errors, touched, setFieldValue }) => (
                <Form>
                    <Section title="Reservas">
                        <div className="mb-4">
                            <CheckboxField
                                name="bookings_are_closed"
                                label="Reservas fechadas para alunos"
                                errors={errors.are_bookings_closed}
                                touched={touched.are_bookings_closed}
                            />
                        </div>

                        <h3 className="h5 mb-3 text-secondary">Datas não permitidas para retirada ou devolução</h3>

                        <FieldArray
                            name="bookings_forbidden_dates"
                            render={(arrayHelpers) => (
                                <div className="mb-4">
                                    {values.bookings_forbidden_dates &&
                                        Boolean(values.bookings_forbidden_dates.length) &&
                                        values.bookings_forbidden_dates.map((_, index) => (
                                            <div
                                                key={index}
                                                className="row mb-4 mb-sm-0 mb-md-0 mb-lg-0 mb-xl-0 mb-xxl-0"
                                            >
                                                <div className="col-sm-5">
                                                    <MonthAndDayField
                                                        name={`bookings_forbidden_dates.${index}.date`}
                                                        label="Mês e dia"
                                                        values={values.bookings_forbidden_dates[index].date}
                                                        // errors={errors.bookings_forbidden_dates[index].date}
                                                        // touched={touched.bookings_forbidden_dates[index].date}
                                                        onChange={(value) =>
                                                            setFieldValue(
                                                                `bookings_forbidden_dates.${index}.date`,
                                                                value
                                                            )
                                                        }
                                                    />
                                                </div>
                                                <div className="col-sm-5">
                                                    <Field
                                                        name={`bookings_forbidden_dates.${index}.name`}
                                                        label="Nome da data"
                                                        // errors={errors[`bookings_forbidden_dates.${index}.description`]}
                                                        // touched={touched.bookings_forbidden_dates[index].name}
                                                    />
                                                </div>
                                                <div className="col-sm-2 align-self-center">
                                                    <Button
                                                        type="button"
                                                        className="btn-outline-secondary"
                                                        onClick={() => arrayHelpers.remove(index)}
                                                    >
                                                        Remover
                                                    </Button>
                                                </div>
                                            </div>
                                        ))}

                                    <Button
                                        type="button"
                                        className="btn-secondary"
                                        onClick={() => arrayHelpers.push(emptyValue)}
                                    >
                                        Adicionar data
                                    </Button>
                                </div>
                            )}
                        />
                    </Section>
                    <Section title="Cópias Finais">
                        <Field
                            as="textarea"
                            name="final_copies_confirmation_message"
                            label="Mensagem para cópias finais ainda não confirmadas"
                            errors={errors.unconfirmed_final_copy_message}
                            touched={touched.unconfirmed_final_copy_message}
                        />
                    </Section>
                    <Button type="submit" className="btn btn-lg btn-primary" isLoading={isLoading}>
                        Editar
                    </Button>
                </Form>
            )}
        </Formik>
    );
}
