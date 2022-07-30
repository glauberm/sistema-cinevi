import React, { useContext, useEffect } from 'react';

import { isRebooted } from '../../services/auth';
import AuthenticationLoginForm from '../../forms/Authentication/AuthenticationLoginForm';
import { NotificationsContext } from '../../contexts/NotificationsProvider';

export default function AuthenticationLoginPage(props) {
    const notifications = useContext(NotificationsContext);

    if (notifications === undefined) {
        throw new Error('O contexto das notificações não foi definido.');
    }

    useEffect(() => {
        isRebooted(notifications);
    }, []);

    return (
        <div className="row">
            <div className="col-lg-5 col-xl-5 col-xxl-4">
                <div className="card mb-5 shadow-lg">
                    <div className="card-header bg-warning bg-gradient">
                        <ul className="nav nav-pills nav-fill card-header-pills justify-content-around">
                            <li className="nav-item">
                                <a className="nav-link active" aria-current="true" href="#">
                                    Entrada
                                </a>
                            </li>
                            <li className="nav-item">
                                <a className="nav-link" href="#">
                                    Cadastro
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div className="card-body">
                        <AuthenticationLoginForm />
                    </div>
                </div>
            </div>
            <div className="col-lg-6 offset-lg-1 col-xl-6 offset-xl-1 col-xxl-7 offset-xxl-1">
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
    );
}
