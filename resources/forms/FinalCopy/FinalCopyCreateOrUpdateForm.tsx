import React, { useState, useContext, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { Formik } from 'formik';
import * as Yup from 'yup';

import { create, show, update } from '../../requests/final-copy';
import { NotificationsContext } from '../../contexts/NotificationsProvider';
import Form from '../../components/Forms/Form';
import Field from '../../components/Forms/Field';
import Button from '../../components/Button';

const initialValues = {
    title: '',
    synopsis: '',
    owner: '',
    production_category: '',
    professor: '',
    genres: '',
    capture_format: '',
    capture_notes: '',
    venues: '',
    video_url: '',
    video_password: '',
    project: '',
    chromia: '',
    proportion: '',
    format: '',
    duration: '',
    native_digital_format: '',
    codec: '',
    container: '',
    bitrate: '',
    fps: '',
    sound: '',
    digital_sound_resolution: '',
    digital_matrix_support: '',
    camera: '',
    editing_software: '',
    sound_capture_equipment: '',
    budget: '',
    financing_sources: '',
    supporters: '',
    has_dcp: '',
    cast: '',
    participations: '',
    prizes: '',
};

const validationSchema = Yup.object({
    title: Yup.string().required('Campo obrigatório'),
    synopsis: Yup.string().required('Campo obrigatório'),
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
                            {/* <SelectField
                                name="owner"
                                label="Responsável"
                                errors={errors.owner}
                                touched={touched.owner}
                            /> */}
                        </div>
                        <div className="col-md">
                            {/* <SelectField
                                name="production_category"
                                label="Modalidade"
                                errors={errors.production_category}
                                touched={touched.production_category}
                            /> */}
                        </div>
                        <div className="col-md">
                            {/* <SelectField
                                name="professor"
                                label="Professor"
                                errors={errors.professor}
                                touched={touched.professor}
                            /> */}
                        </div>
                    </div>
                    <div className="row">
                        {/* <SelectField
                            name="genres"
                            label="Gênero(s)"
                            isMulti
                            errors={errors.genres}
                            touched={touched.genres}
                        /> */}
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
                            <Field
                                type="text"
                                name="video_url"
                                label="URL do vídeo"
                                errors={errors.video_url}
                                touched={touched.video_url}
                            />
                        </div>
                        <div className="col-md">
                            <Field
                                type="text"
                                name="video_password"
                                label="Senha do vídeo"
                                errors={errors.video_password}
                                touched={touched.video_password}
                            />
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-md">
                            <Field
                                type="text"
                                name="project"
                                label="Projeto"
                                errors={errors.project}
                                touched={touched.project}
                            />
                        </div>
                        <div className="col-md">
                            <Field
                                type="text"
                                name="chromia"
                                label="Cromia"
                                errors={errors.chromia}
                                touched={touched.chromia}
                            />
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-md">
                            <Field
                                type="text"
                                name="proportion"
                                label="Proporção"
                                errors={errors.proportion}
                                touched={touched.proportion}
                            />
                        </div>
                        <div className="col-md">
                            <Field
                                type="text"
                                name="format"
                                label="Formato"
                                errors={errors.format}
                                touched={touched.format}
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
