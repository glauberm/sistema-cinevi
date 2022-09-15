import React, { ReactElement, useContext, useEffect } from 'react';
import { Link } from 'react-router-dom';

import { AuthContext } from '../contexts/AuthProvider';
import Logo from '../images/Logo.svg';
import Uff from '../images/Uff.svg';
import authentication from '../routes/authentication';

type Props = {
    children: ReactElement;
};

export default function BaseLayout(props: Props) {
    const authProvider = useContext(AuthContext);

    useEffect(() => {
        const loading = document.getElementById('loading');

        if (loading === null) {
            throw new DOMException('Elemento #loading não encontrado', 'NotFoundError');
        }

        loading.hidden = true;
        loading.style.display = 'none';

        return () => {
            loading.hidden = false;
            loading.style.display = 'flex';
        };
    }, []);

    return (
        <div className="d-flex w-100 h-100 pt-5 pb-3 mx-auto flex-column">
            <div className="mb-auto">
                <div className="container">
                    <header className="mx-auto text-center">
                        <Link
                            className="d-inline-block"
                            to={authProvider.isAuthenticated ? authentication.profile.path : authentication.login.path}
                        >
                            <Logo />
                        </Link>
                    </header>
                </div>
            </div>

            <main className="py-5">
                <div className="container">{props.children}</div>
            </main>

            <footer className="mt-auto text-secondary">
                <div className="container text-center mb-4">
                    <a href="http://uff.br/" target="_blank" rel="noopener noreferrer">
                        <Uff />
                    </a>
                </div>
            </footer>
        </div>
    );
}
