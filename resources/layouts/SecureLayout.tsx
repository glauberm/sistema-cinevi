import React, { useEffect, useState } from 'react';

import PublicLayout from './PublicLayout';
import Navigation from '../components/Navigation';

export default function SecureLayout(props) {
    const [isMenuActive, setMenuActive] = useState(true);

    useEffect(() => {
        if (isMenuActive) {
            document.documentElement.classList.remove('is-menu-inactive');
            document.documentElement.classList.add('is-menu-active');
        } else {
            document.documentElement.classList.remove('is-menu-active');
            document.documentElement.classList.add('is-menu-inactive');
        }

        return () => {
            document.documentElement.classList.remove('is-menu-active');
            document.documentElement.classList.remove('is-menu-inactive');
        };
    }, [isMenuActive]);

    const toggleMenu = () => {
        setMenuActive(!isMenuActive);
    };

    return (
        <PublicLayout>
            <div className="row">
                <div className="col-lg-3">
                    <Navigation />
                </div>
                <div className="col-lg-9">
                    <div className="h-100 p-5 mb-5 bg-white rounded-3">{props.children}</div>
                </div>
            </div>
        </PublicLayout>
    );
}
