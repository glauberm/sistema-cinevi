import React, { useState, useContext, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { Formik } from 'formik';
import * as Yup from 'yup';

import { create, show, update } from '../../requests/production-role';
import { NotificationsContext } from '../../contexts/NotificationsProvider';
import Form from '../../components/Forms/Form';
import SelectField from '../../components/Forms/SelectField';
import DateTimeField from '../../components/Forms/DateTimeField';
import Button from '../../components/Button';

const initialValues = {
    owner_id: '',
    project_id: '',
    withdrawal_date: '',
    devolution_date: '',
    bookables: [],
};

const validationSchema = Yup.object({
    owner_id: Yup.string().required('Campo obrigatório'),
    project_id: Yup.string().required('Campo obrigatório'),
    withdrawal_date: Yup.string().required('Campo obrigatório'),
    devolution_date: Yup.string().required('Campo obrigatório'),
    bookables: Yup.array().min(1, 'A reserva deve ter ao menos um reservável'),
});

export default function (props) {
    const [isLoading, setLoading] = useState(false);
    const [values, setValues] = useState(initialValues);

    const notifications = useContext(NotificationsContext);
    const navigate = useNavigate();

    const onSubmit = (values) => {
        if (props.id) {
            update(notifications, navigate, setLoading, props.id, values);
        } else {
            create(notifications, navigate, setLoading, values);
        }
    };

    useEffect(() => {
        if (props.id) {
            // if (showRequest === 'revision') {
            //     showRevision(id);
            // } else {
            show(notifications, setValues, setLoading, props.id);
            // }
        }
    }, []);

    return (
        <Formik enableReinitialize initialValues={values} validationSchema={validationSchema} onSubmit={onSubmit}>
            {({ errors, touched }) => (
                <Form>
                    <div className="row">
                        <div className="col-md">
                            <SelectField
                                name="owner_id"
                                label="Responsável"
                                errors={errors.owner_id}
                                touched={touched.owner_id}
                            />
                        </div>
                        <div className="col-md">
                            <SelectField
                                name="project_id"
                                label="Responsável"
                                errors={errors.project_id}
                                touched={touched.project_id}
                            />
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-md">
                            <DateTimeField
                                name="withdrawal_date"
                                label="Data de Retirada"
                                errors={errors.withdrawal_date}
                                touched={touched.withdrawal_date}
                            />
                        </div>
                        <div className="col-md">
                            <DateTimeField
                                name="devolution_date"
                                label="Data de Devolução"
                                errors={errors.devolution_date}
                                touched={touched.devolution_date}
                            />
                        </div>
                    </div>
                    <SelectField
                        name="bookables"
                        label="Reserváveis"
                        isMulti
                        errors={errors.bookables}
                        touched={touched.bookables}
                    />

                    <Button type="submit" className="btn btn-lg btn-primary" isLoading={isLoading}>
                        {props.id ? 'Editar' : 'Criar'}
                    </Button>
                </Form>
            )}
        </Formik>
    );
}
