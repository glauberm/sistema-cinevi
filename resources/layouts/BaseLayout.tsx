import React, { ReactElement, useEffect } from 'react';
import { Link } from 'react-router-dom';

import Logo from '../images/Logo.svg';
import Uff from '../images/Uff.svg';

interface BaseLayoutProps {
    children: ReactElement;
}

export default function (props: BaseLayoutProps) {
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
                        <Link to="/">
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
                    <a href="http://uff.br/" target="_blank">
                        <Uff />
                    </a>
                </div>
            </footer>
        </div>
    );
}
