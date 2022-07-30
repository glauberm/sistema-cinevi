import React, { ReactElement, useEffect } from 'react';
import { Link } from 'react-router-dom';

import Logo from '../images/Logo.svg';
import Uff from '../images/Uff.svg';

interface PublicLayoutProps {
    children: ReactElement;
}

export default function PublicLayout(props: PublicLayoutProps) {
    useEffect(() => {
        const loading = document.getElementById('loading');

        if (loading === null) {
            throw new Error('Elemento #loading não encontrado');
        }

        loading.hidden = true;
        loading.style.display = 'none';

        return () => {
            loading.hidden = false;
            loading.style.display = 'flex';
        };
    }, []);

    return (
        <div className="d-flex w-100 h-100 pt-5 pb-3 mx-auto flex-column bg-light">
            <div className="mb-auto bg-light">
                <div className="container">
                    <header className="mx-auto text-center">
                        <Link to="/">
                            <Logo />
                        </Link>
                    </header>
                </div>
            </div>

            <main className="py-5 bg-light">
                <div className="container">{props.children}</div>
            </main>

            <footer className="mt-auto bg-light text-secondary">
                <div className="container text-center mb-4">
                    <a href="http://uff.br/" target="_blank">
                        <Uff />
                    </a>
                </div>
            </footer>
        </div>
    );
}
