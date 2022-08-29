import React, { useState, useContext, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { Formik } from 'formik';
import * as Yup from 'yup';

import { create, show, update } from '../../requests/production-role';
import { NotificationsContext } from '../../contexts/NotificationsProvider';
import Form from '../../components/Forms/Form';
import Field from '../../components/Forms/Field';
import Button from '../../components/Button';
import SelectField from '../../components/Forms/SelectField';
import DateTimeField from '../../components/Forms/DateTimeField';
import CheckboxField from '../../components/Forms/CheckboxField';

const initialValues = {
    title: '',
    synopsis: '',
    owner: '',
    production_category: '',
    professor: '',
    genres: [],
    capture_format: '',
    capture_notes: '',
    venues: '',
    pre_production_date: '',
    production_date: '',
    post_production_date: '',
    has_attended_photography_discipline: false,
    has_attended_sound_discipline: false,
    has_attended_art_discipline: false,
};

const validationSchema = Yup.object({
    title: Yup.string().required('Campo obrigatório'),
    synopsis: Yup.string().required('Campo obrigatório'),
    // owner: Yup.string().required('Campo obrigatório'),
    // production_category: '',
    // professor: '',
    // genres: [],
    capture_format: Yup.string().nullable(),
    capture_notes: Yup.string().nullable(),
    venues: Yup.string().nullable(),
    pre_production_date: Yup.string().nullable(),
    production_date: Yup.string().nullable(),
    post_production_date: Yup.string().nullable(),
    has_attended_photography_discipline: Yup.bool().required('Campo obrigatório'),
    has_attended_sound_discipline: Yup.bool().required('Campo obrigatório'),
    has_attended_art_discipline: Yup.bool().required('Campo obrigatório'),
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
                    <Field name="title" label="Título" type="text" errors={errors.title} touched={touched.title} />
                    <Field
                        name="synopsis"
                        label="Sinopse"
                        as="textarea"
                        errors={errors.synopsis}
                        touched={touched.synopsis}
                    />
                    <div className="row">
                        <div className="col-md">
                            <SelectField
                                name="owner"
                                label="Responsável"
                                errors={errors.owner}
                                touched={touched.owner}
                            />
                        </div>
                        <div className="col-md">
                            <SelectField
                                name="production_category"
                                label="Modalidade"
                                errors={errors.production_category}
                                touched={touched.production_category}
                            />
                        </div>
                        <div className="col-md">
                            <SelectField
                                name="professor"
                                label="Professor"
                                errors={errors.professor}
                                touched={touched.professor}
                            />
                        </div>
                    </div>
                    <div className="row">
                        <SelectField
                            name="genres"
                            label="Gênero(s)"
                            isMulti
                            errors={errors.genres}
                            touched={touched.genres}
                        />
                        <Field
                            type="text"
                            name="capture_format"
                            label="Captação"
                            errors={errors.capture_format}
                            touched={touched.capture_format}
                        />
                    </div>
                    <div className="row">
                        <div className="col-md">
                            <Field
                                name="capture_notes"
                                label="Detalhes da Captação"
                                as="textarea"
                                errors={errors.capture_notes}
                                touched={touched.capture_notes}
                            />
                        </div>
                        <div className="col-md">
                            <Field
                                name="venue"
                                label="Locações"
                                as="textarea"
                                errors={errors.venue}
                                touched={touched.venue}
                            />
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-md">
                            <DateTimeField
                                name="pre_production_date"
                                label="Pré-produção"
                                errors={errors.pre_production_date}
                                touched={touched.pre_production_date}
                            />
                        </div>
                        <div className="col-md">
                            <DateTimeField
                                name="production_date"
                                label="Produção"
                                errors={errors.production_date}
                                touched={touched.production_date}
                            />
                        </div>
                        <div className="col-md">
                            <DateTimeField
                                name="post_production_date"
                                label="Pós-produção"
                                errors={errors.post_production_date}
                                touched={touched.post_production_date}
                            />
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-md">
                            <SelectField
                                name="direction"
                                label="Direção"
                                isMulti
                                errors={errors.direction}
                                touched={touched.direction}
                            />
                        </div>
                        <div className="col-md">
                            <SelectField
                                name="production"
                                label="Produção"
                                isMulti
                                errors={errors.production}
                                touched={touched.production}
                            />
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-md">
                            <SelectField
                                name="photography_direction"
                                label="Direção de Fotografia"
                                isMulti
                                errors={errors.photography_direction}
                                touched={touched.photography_direction}
                            />
                        </div>
                        <div className="col-md">
                            <CheckboxField
                                name="has_attended_photography_discipline"
                                label="Já cursou(aram) a disciplina de Fotografia e Iluminação?"
                                errors={errors.has_attended_photography_discipline}
                                touched={touched.has_attended_photography_discipline}
                            />
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-md">
                            <SelectField
                                name="sound_direction"
                                label="Direção de Som"
                                isMulti
                                errors={errors.sound_direction}
                                touched={touched.sound_direction}
                            />
                        </div>
                        <div className="col-md">
                            <CheckboxField
                                name="has_attended_sound_discipline"
                                label="Já cursou(aram) a disciplina de Técnica de Som em Cinema e Audiovisual"
                                errors={errors.has_attended_sound_discipline}
                                touched={touched.has_attended_sound_discipline}
                            />
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-md">
                            <SelectField
                                name="art_direction"
                                label="Direção de Arte"
                                isMulti
                                errors={errors.art_direction}
                                touched={touched.art_direction}
                            />
                        </div>
                        <div className="col-md">
                            <CheckboxField
                                name="has_attended_art_discipline"
                                label="Já cursou(aram) a disciplina de Design Visual"
                                errors={errors.has_attended_art_discipline}
                                touched={touched.has_attended_art_discipline}
                            />
                        </div>
                    </div>
                    <Button type="submit" className="btn btn-lg btn-primary" isLoading={isLoading}>
                        {props.id ? 'Editar' : 'Criar'}
                    </Button>
                </Form>
            )}
        </Formik>
    );
}
