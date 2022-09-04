import React, { ReactElement } from 'react';
import { NavLink } from 'react-router-dom';

import authentication from '../routes/authentication';
import BaseLayout from './BaseLayout';

type Props = {
    children: ReactElement;
};

export default function PublicLayout(props: Props) {
    return (
        <BaseLayout>
            <div className="row">
                <div className="col-lg-5 col-xl-5 col-xxl-4">
                    <div className="card mb-5 shadow-lg">
                        <div className="card-header bg-warning bg-gradient">
                            <ul className="nav nav-pills nav-fill card-header-pills justify-content-around">
                                <li className="nav-item">
                                    <NavLink
                                        to={authentication.login.path}
                                        className={({ isActive }) => (isActive ? 'nav-link active' : 'nav-link')}
                                    >
                                        Entrada
                                    </NavLink>
                                </li>
                                <li className="nav-item">
                                    <NavLink
                                        to={authentication.register.path}
                                        className={({ isActive }) => (isActive ? 'nav-link active' : 'nav-link')}
                                    >
                                        Cadastro
                                    </NavLink>
                                </li>
                            </ul>
                        </div>
                        <div className="card-body">{props.children}</div>
                    </div>
                </div>
                <div className="col-lg-6 offset-lg-1 col-xl-6 offset-xl-1 col-xxl-7 offset-xxl-1 d-flex align-items-center">
                    <div className="jumbotron">
                        <h1 className="display-4 fw-bolder mb-4 text-warning jumbotron__title">
                            Todos os serviços do departamento em qualquer lugar.
                        </h1>

                        <p className="fs-4 text-primary">
                            Cadastre projetos, reserve equipamentos no almoxarifado e muito mais pelo celular, tablet ou
                            qualquer outro dispositivo com acesso à internet.
                        </p>

                        <p className="text-secondary">
                            <strong>
                                Sistema para alunos, funcionários ou professores do Departamento de Cinema e Vídeo da
                                Universidade Federal Fluminense.
                            </strong>
                        </p>
                    </div>
                </div>
            </div>
        </BaseLayout>
    );
}
